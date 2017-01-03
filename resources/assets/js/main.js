import Vue from 'vue';
import Vuex from 'vuex';
import Navbar from './components/navbar/navbar.vue';
import store from './store/index';
import router from './router';
import {mapActions} from 'vuex';

new Vue({
    store,
    router,
    el: '#app',

    components: {
        Navbar
    },

    created()
    {
        this.loadAccounts();
    },

    methods: {
        // jshint ignore:start
        ...mapActions(['loadAccounts'])
        // jshint ignore:end
    }
});
