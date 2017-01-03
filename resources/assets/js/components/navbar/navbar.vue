<template>
    <nav class="nav">
        <div class="nav-left">
            <router-link :to="{name: 'tasks.index'}" class="nav-item is-tab">Tasks</router-link>
            <router-link :to="{name: 'reports.create'}" class="nav-item is-tab">Reports</router-link>
        </div>
    </nav>
</template>

<script>
export default {
    name: 'Navbar'
}
</script>
