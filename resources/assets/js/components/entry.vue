<template>
    <tr>
        <td>{{ entry.hours }}</td>
        <td>{{ entry.task.account.name }}</td>
        <td>{{ entry.task.name }}</td>
        <td class="has-text-centered">
            <button class="button is-small" :class="{'is-loading': loading}" type="button" @click="deleteEntry(entry.id)">&times;</button>
        </td>
    </tr>
</template>

<script>
import axios from 'axios';
import {mapActions} from 'vuex';

export default {
    name: 'Entry',
    props: {
        entry: {
            type: Object,
            required: true
        }
    },

    data()
    {
        return {
            loading: false
        };
    },

    methods: {
        ...mapActions(['removeEntry']),

        deleteEntry(id)
        {
            this.loading = true;

            axios.delete(`/entries/${id}`)
                .then(response => {
                    this.removeEntry(id);
                })
                .catch(error => alert(error.message))
                .then(this.loading = false);
        }
    }
}
</script>
