<template>
    <div>
        <div class="control">
            <div class="columns">
                <div class="column">
                    <label class="label">Account</label>
                    <select class="input" v-model="id">
                        <option v-for="account in accounts" :value="account.id" v-text="account.name"></option>
                    </select>
                </div>
                <div class="column is-narrow">
                    <div class="label">&nbsp;</div>
                    <button class="button" type="button" @click="toggleAddAccount">+</button>
                </div>
            </div>
        </div>

        <div v-show="addAccountIsVisible">
            <div class="help">Add new account</div>
            <div class="columns">
                <div class="column">
                    <input type="text" class="input is-small"
                        ref="newAccountInput"
                        placeholder="Account name"
                        v-model="newAccountName"
                        @keypress.enter.prevent="addAccount"
                    >
                </div>
                <div class="column is-narrow">
                    <button class="button is-small is-primary" type="button"
                        :class="{'is-loading': addingAccount}"
                        :disabled="! hasNewAccountName"
                        @click="addAccount"
                    >
                        Add
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import axios from 'axios';

export default {
    name: 'Account',

    data() {
        return {
            id: null,
            newAccountName: '',
            addAccountIsVisible: false,
            addingAccount: false
        }
    },

    created()
    {
        this.id = this.accounts.length ? this.accounts[0].id : null;
    },

    watch: {
        id(id)
        {
            this.emitValue(id);
        }
    },

    computed: {
        ...mapGetters(['accounts']),

        hasNewAccountName()
        {
            return this.newAccountName.trim() != '';
        }
    },

    methods: {
        emitValue(value) {
            this.$emit('input', parseInt(value, 10));
        },

        toggleAddAccount()
        {
            this.addAccountIsVisible = !this.addAccountIsVisible;

            if (! this.addAccountIsVisible) {
                this.newAccountName = '';
            } else {
                this.$nextTick(() => {
                    this.$refs.newAccountInput.focus();
                });
            }

        },

        addAccount()
        {
            if (! this.hasNewAccountName) {
                return;
            }

            this.addingAccount = true;

            axios.post('/api/accounts', {name: this.newAccountName})
                .then(response => {
                    const account = response.data.account;

                    this.$store.commit('ADD_ACCOUNT', account);
                    this.id = account.id;

                    this.toggleAddAccount();
                })
                .catch(error => alert(error.message))
                .then(() => this.addingAccount = false);
        }
    }
}
</script>
