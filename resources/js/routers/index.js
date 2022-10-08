import { createWebHistory, createRouter } from 'vue-router';
// import store from '@/store';
import routes from './routes';
// import Cookies from 'js-cookie';
// import axios from '@/utils/axios';
// import {formatAsNestedRoutes} from '@/utils/helpers';

const router = createRouter({
    history: createWebHistory(),
    routes
});

// const $store = store;

// 初始路由
/*const routeObj = {
    path: '/',
    meta: {
        title: '首页'
    },
    component: () => import('@/page/main.vue'),
    children: [
        {
            path: '',
            name: 'home',
            meta: {
                title: '首页'
            },
            component: () => import('@/page/home/index.vue')
        }
    ]
};*/

const LOGIN_PAGE_NAME = 'Login';

//vue-router导航全局前置守卫
router.beforeEach((to, from, next) => {
    // $store.commit('setToken');
    // const token = $store.state.token; // 获取登录 token
    // const nodeKey = window.atob(localStorage.getItem('nodeKey')).split(',');    // 获取权限节点

    /* if (!token && to.name !== LOGIN_PAGE_NAME){
        next({
            name: 'Login'
        })
    } */ /*else if (to.meta.hasOwnProperty('node') && !nodeKey.some(resolve => resolve === to.meta.node)) {
        // 鉴权页面权限，无权限则重定向至提示页面
        next({
            name: 'Authorize'
        })
    }*/


    next();
});


//vue-router导航全局后置钩子
router.afterEach(to => {

});

export default router;