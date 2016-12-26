import Vue from 'vue';
import Vuex from 'vuex';
import App from './components/app.vue';
import store from './store/index';

new Vue({
    store,
    el: '#app',
    components: {App}
});
