<template>
    <span class="columns entry">
        <div class="column is-1">{{ entry.hours }}</div>
        <div class="column is-4">{{ entry.task.account.name }}</div>
        <div class="column is-5">{{ entry.task.name }}</div>
        <div class="column is-narrow">
            <div class="has-text-centered">
                <button class="button is-small is-danger" :class="{'is-loading': loading}" type="button" @click="deleteEntry(entry.id)">&times;</button>
            </div>
        </div>
    </span>
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

            axios.delete(`/api/entries/${id}`)
                .then(response => {
                    this.removeEntry(id);
                })
                .catch(error => alert(error.message))
                .then(this.loading = false);
        }
    }
}
</script>
