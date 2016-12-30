<template>
    <div>
        <div class="columns">
            <div class="column is-1"><strong>Hours</strong></div>
            <div class="column is-4"><strong>Account</strong></div>
            <div class="column is-5">Task</div>
        </div>
        <transition-group name="bounce">
            <entry v-for="entry in entries" :entry="entry" :key="entry.id"></entry>
        </transition-group>
    </div>
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
