<template>
    <div class="modal is-active">
        <form @submit.prevent="submit">
            <div class="modal-background"></div>

            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Add new entry</p>
                    <button class="delete" type="button" @click="close" v-show="! loading"></button>
                </header>

                <div class="modal-card-body">
                    <div class="columns">
                        <div class="column">
                            <date v-model="entry.date"></date>
                        </div>
                        <div class="column">
                            <account v-model="entry.account_id"></account>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <task v-model="entry.task_id" :account-id="entry.account_id"></task>
                        </div>
                        <div class="column">
                            <div class="control">
                                <label class="label">Hours</label>
                                <input class="input" type="number" step="0.25" min="0.25" max="8.50" placeholder="0.00" v-model="entry.hours">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-card-foot">
                    <button class="button is-primary" :class="{'is-loading': loading}" type="submit">Add entry</button>
                    <span class="help is-danger" v-text="error" v-show="error"></span>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import Date from './date.vue';
import Account from './account.vue';
import Task from './task.vue';

export default {
    name: 'AddEntry',
    components: {Date, Account, Task},

    props: {
        defaultDate: {
            type: String,
            required: true
        }
    },

    data() {
        return {
            loading: false,
            error: null,
            entry: {
                date: null,
                hours: null,
                task_id: null,
                account_id: null
            }
        }
    },

    created() {
        this.entry.date = this.defaultDate;
    },

    methods: {
        submit()
        {
            this.error = null;
            this.loading = true;

            axios.post('/entries', this.entry)
                .then(response => {
                    this.$emit('entry-added', response.data.entry);
                    this.close();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.error = this.getFirstErrorMessage(error.response);
                    }
                })
                .then(() => this.loading = false);
        },

        getFirstErrorMessage(response)
        {
            const key = Object.keys(response.data)[0];
            return response.data[key][0];
        },

        close()
        {
            this.$emit('close');
        }
    }
}
</script>
