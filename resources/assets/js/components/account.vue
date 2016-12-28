<template>
    <div>
        <div class="control">
            <div class="columns">
                <div class="column">
                    <label class="label">Account</label>
                    <select class="input" @input="emitValue($event.target.value)" v-model="id">
                        <option v-for="account in accounts" :value="account.id" v-text="account.name"></option>
                    </select>
                </div>
                <div class="column is-narrow">
                    <div class="label">&nbsp;</div>
                    <button class="button" type="button" @click="showAddAccount">+</button>
                </div>
            </div>
        </div>

        <div class="control" v-show="addAccountIsVisible">
            <div class="help">Add new account</div>
            <div class="columns">
                <div class="column">
                    <input type="text" class="input is-small"
                        ref="newAccountInput"
                        placeholder="Account's name"
                        v-model="newAccountName"
                        @keypress.enter.prevent="addAccount"
                    >
                </div>
                <div class="column is-narrow">
                    <button class="button is-small is-primary" :class="{'is-loading': addingAccount}" type="button" :disabled="! hasNewAccountName" @click="addAccount">Add</button>
                    <button class="button is-small" type="button" @click="hideAddAccount" :disabled="addingAccount">&times;</button>
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
        if (this.accounts.length > 0) {
            this.id = this.accounts[0].id;
        }
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

        showAddAccount()
        {
            this.addAccountIsVisible = true;

            this.$nextTick(() => {
                this.$refs.newAccountInput.focus();
            });
        },

        hideAddAccount()
        {
            this.newAccountName = '';
            this.addAccountIsVisible = false;
        },

        addAccount()
        {
            if (! this.hasNewAccountName) {
                return;
            }

            this.addingAccount = true;

            axios.post('/accounts', {name: this.newAccountName})
                .then(response => {
                    const account = response.data.account;

                    this.$store.commit('ADD_ACCOUNT', account);
                    this.id = account.id;

                    this.hideAddAccount();
                })
                .catch(error => alert(error.message))
                .then(() => this.addingAccount = false);
        }
    }
}
</script>
