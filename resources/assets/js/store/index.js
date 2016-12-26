import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        entries: []
    },

    getters: {
        entries: state => state.entries
    },

    mutations: {
        ENTRIES(state, entries)
        {
            state.entries = entries;
        },

        ADD_ENTRY(state, entry)
        {
            state.entries.push(entry);
        }
    },

    actions: {
        loadEntries({commit}, date)
        {
            axios.get(`/entries/date/${date}`)
                .then(response => commit('ENTRIES', response.data.entries))
                .catch(error => alert(error.message));
        },

        removeEntry({state, commit}, id)
        {
            commit('ENTRIES', state.entries.filter(e => e.id != id));
        }
    }
});
