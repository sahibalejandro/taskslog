<template>
    <table class="table is-narrow">
        <thead>
            <tr>
                <th>Hours</th>
                <th>Account</th>
                <th>Task</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody v-if="entries.length > 0">
            <entry v-for="entry in entries" :entry="entry"></entry>
        </tbody>
        <tbody v-else>
            <tr>
                <td colspan="4">No entries</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
import Entry from './entry.vue';

export default {
    name: 'Entries',
    components: {Entry},
    props: {
        entries: {
            type: Array,
            required: true
        }
    }
}
</script>
