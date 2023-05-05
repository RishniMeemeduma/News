import VueRouter from 'vue-router';
import Vue from 'vue';
import routes from './router.js';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes
})

export default router;

