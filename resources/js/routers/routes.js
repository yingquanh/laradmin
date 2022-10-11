import Login from '@/pages/Login';
import Layout from '@/layouts/DefaultLayout';
import Dashboard from '@/pages/Dashboard';
import Account from '@/pages/Settings/Account';
import Role from '@/pages/Settings/Role';
import TableList from '@/pages/TableList';

export default [
    {
        path: '/login',
        name: 'Login',
        component: () => Login
    },
    /* {
        path: '/recover',
        name: 'Recover',
        component: () => import('@/pagess/common/recover.vue')
    }, */
    {
        path: '/',
        name: 'Home',
        meta: {
            title: '系统首页',
            showInbreadcrumb: true,
        },
        component: () => Layout,
        children: [
            {
                path: '',
                name: 'Home',
                meta: {
                    title: '系统首页',
                    parent: false,
                    showInbreadcrumb: false,
                },
                component: Dashboard
            },
            {
                path: 'table_list',
                name: 'TableList',
                meta: {
                    title: '数据表格',
                    parent: false,
                    showInbreadcrumb: true,
                },
                component: TableList
            },
            {
                path: 'settings',
                name: 'Settings',
                meta: {
                    title: '系统设置',
                    parent: true,
                    node: 'admin.settings',
                    showInbreadcrumb: true,
                },
                redirect: { name: 'Account' },
                children: [
                    {
                        path: 'account',
                        name: 'Account',
                        meta: {
                            title: '账号管理',
                            parent: false,
                            node: 'admin.settings.account',
                            showInbreadcrumb: true,
                        },
                        component: Account
                    },
                    {
                        path: 'role',
                        name: 'Role',
                        meta: {
                            title: '角色管理',
                            parent: false,
                            node: 'admin.settings.role',
                            showInbreadcrumb: true,
                        },
                        component: Role
                    },
                ]
            },
            /* {
                path: 'policy/create',
                name: 'CreatePolicy',
                meta: {
                    title: '新增政务信息',
                    node: 'admin.policy.create',
                },
                component: () => import('@/pages/policy/components/create')
            }, */
            /* {
                path: '/authorize',
                name: 'Authorize',
                meta: {
                    title: 'Authorize'
                },
                component: () => import('@/pages/common/authorize.vue')
            } */
        ]
    }
];