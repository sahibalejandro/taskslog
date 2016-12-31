<template>
    <div class="modal is-active">
        <form @submit.prevent="submit">
            <div class="modal-background"></div>

            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title">Add new entry</p>
                    <button class="delete" type="button" @click="close" v-show="! form.isLoading"></button>
                </header>

                <div class="modal-card-body">
                    <div class="columns">
                        <div class="column">
                            <date v-model="form.date"></date>
                        </div>
                        <div class="column">
                            <account v-model="form.account_id"></account>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <task v-model="form.task_id" :account-id="form.account_id"></task>
                        </div>
                        <div class="column">
                            <div class="control">
                                <label class="label">Hours</label>
                                <input class="input" type="number" step="0.25" min="0.25" max="8.50" placeholder="0.00" v-model="form.hours">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-card-foot">
                    <button class="button is-primary" :class="{'is-loading': form.isLoading}" type="submit">Add entry</button>
                    <span class="help is-danger" v-text="form.errors.first()" v-show="form.errors.any()"></span>
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
import Form from '../form';

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
            form: new Form({
                date: null,
                hours: null,
                task_id: null,
                account_id: null
            })
        }
    },

    created() {
        this.form.date = this.defaultDate;
    },

    methods: {
        submit()
        {
            this.form.post('/entries')
                .then(response => {
                    this.$emit('entry-added', response.data.entry);
                    this.close();
                })
                .catch(error => {});
        },

        close()
        {
            this.$emit('close');
        }
    }
}
</script>
