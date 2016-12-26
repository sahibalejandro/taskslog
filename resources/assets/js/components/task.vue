<template>
    <div class="control">
        <label class="label">Task</label>
        <select class="input" @input="emitValue($event.target.value)" v-model="id">
            <option v-for="task in tasks" :value="task.id" v-text="task.name"></option>
        </select>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Task',

    props: {
        accountId: {
            required: true
        }
    },

    data() {
        return {
            id: null,
            tasks: []
        }
    },

    watch: {
        accountId() {
            this.loadTasks();
        }
    },

    methods: {
        loadTasks() {
            axios.get(`/accounts/${this.accountId}/tasks`)
                .then(response => {
                    this.tasks = response.data.tasks;

                    // Select first task in the list
                    if (this.tasks.length > 0) {
                        this.id = this.tasks[0].id;
                        this.emitValue(this.id);
                    }
                })
                .catch(error => alert(error.message));
        },

        emitValue(value) {
            this.$emit('input', parseInt(value));
        }
    }
}
</script>
