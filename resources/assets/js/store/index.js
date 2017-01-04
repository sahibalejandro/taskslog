import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        accounts: [],
        entries: []
    },

    getters: {
        entries: state => state.entries,
        accounts: state => state.accounts
    },

    mutations: {
        ENTRIES(state, entries)
        {
            state.entries = entries;
        },

        ADD_ENTRY(state, entry)
        {
            state.entries.push(entry);
        },

        ACCOUNTS(state, accounts)
        {
            state.accounts = accounts;
        },

        ADD_ACCOUNT(state, account)
        {
            state.accounts.push(account);
        }
    },

    actions: {
        loadEntries({commit}, date)
        {
            axios.get(`/api/entries/date/${date}`)
                .then(response => commit('ENTRIES', response.data.entries))
                .catch(error => alert(error.message));
        },

        removeEntry({state, commit}, id)
        {
            commit('ENTRIES', state.entries.filter(e => e.id != id));
        },

        loadAccounts({commit})
        {
            axios.get('/api/accounts')
                .then(response => commit('ACCOUNTS', response.data.accounts))
                .catch(error => alert(error.message));
        }
    }
});
