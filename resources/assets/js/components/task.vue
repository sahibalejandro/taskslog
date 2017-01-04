<template>
    <div>
        <div class="control">
            <div class="columns">
                <div class="column">
                    <label class="label">Task</label>
                    <select class="input" v-model="id">
                        <option v-for="task in tasks" :value="task.id" v-text="task.name"></option>
                    </select>
                </div>
                <div class="column is-narrow">
                    <div class="label">&nbsp;</div>
                    <button class="button" type="button" @click="toggleAddTask">+</button>
                </div>
            </div>
        </div>
        <div v-show="addTaskIsVisible">
            <div class="help">Add new task</div>
            <div class="columns">
                <div class="column">
                    <input type="text" class="input is-small"
                        ref="newTaskNameInput"
                        placeholder="Task description"
                        v-model="newTaskName"
                        @keypress.enter.prevent="addTask"
                    >
                </div>
                <div class="column is-narrow">
                    <button class="button is-small is-primary" type="button" :class="{'is-loading': addingTask}" :disabled="! hasTaskName" @click="addTask">Add</button>
                </div>
            </div>
        </div>
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
            tasks: [],
            newTaskName: '',
            addingTask: false,
            addTaskIsVisible: false
        }
    },

    watch: {
        accountId() {
            this.loadTasks();
        },

        id(id)
        {
            this.emitValue(id);
        }
    },

    computed: {
        hasTaskName()
        {
            return this.newTaskName.trim() != '';
        }
    },

    methods: {
        emitValue(value) {
            this.$emit('input', parseInt(value));
        },

        toggleAddTask()
        {
            this.addTaskIsVisible = !this.addTaskIsVisible;

            if (! this.addTaskIsVisible) {
                this.newTaskName = '';
            } else {
                this.$nextTick(() => {
                    this.$refs.newTaskNameInput.focus();
                });
            }
        },

        loadTasks() {
            axios.get(`/api/accounts/${this.accountId}/tasks`)
                .then(response => {
                    this.tasks = response.data.tasks;

                    // Select first task in the list
                    this.id = this.tasks.length ? this.tasks[0].id : null;
                })
                .catch(error => alert(error.message));
        },

        addTask()
        {
            const data = {
                name: this.newTaskName,
                account_id: this.accountId,
            };

            this.addingTask = true;

            axios.post('/api/tasks', data)
                .then(response => {
                    const task = response.data.task;
                    this.id = task.id;

                    this.tasks.push(task);
                    this.toggleAddTask();
                })
                .catch(error => alert(error.message))
                .then(() => this.addingTask = false);
        }
    }
}
</script>
