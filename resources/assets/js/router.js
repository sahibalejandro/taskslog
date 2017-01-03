import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    linkActiveClass: 'is-active',
    routes: [
        {
            path: '/tasks',
            name: 'tasks.index',
            component: require('./components/tasks.vue')
        },
        {
            path: '/reports',
            name: 'reports.create',
            component: require('./components/reports/reports.vue')
        }
    ]
});
