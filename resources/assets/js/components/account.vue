<template>
    <div class="control">
        <label class="label">Account</label>
        <select class="input" @input="emitValue($event.target.value)">
            <option v-for="account in accounts" :value="account.id" v-text="account.name"></option>
        </select>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Account',

    data() {
        return {
            accounts: []
        }
    },

    created() {
        axios.get('/accounts')
            .then(response => {
                this.accounts = response.data.accounts;

                // Select first account in the list.
                if (this.accounts.length > 0) {
                    this.emitValue(this.accounts[0].id);
                }
            })
            .catch(error => alert(error.message));
    },

    methods: {
        emitValue(value) {
            this.$emit('input', parseInt(value, 10));
        }
    }
}
</script>
