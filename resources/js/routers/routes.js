// import LoginHome from '@/pages/Login';
import SiderMenu from '@/layouts/SiderMenu';
import Dashboard from '@/pages/Dashboard';
import Account from '@/pages/Settings/Account';
import Role from '@/pages/Settings/Role';

export default [
    {
        path: '/login',
        name: 'Login',
        component: () => import('@/pages/Login')
    },
    /* {
        path: '/recover',
        name: 'Recover',
        component: () => import('@/pagess/common/recover.vue')
    }, */
    {
        path: '/',
        name: 'App',
        meta: {
            title: 'App'
        },
        component: () => SiderMenu,
        children: [
            {
                path: '',
                name: 'Dashboard',
                meta: {
                    title: 'Dashboard'
                },
                component: () => Dashboard
            },
            {
                path: 'settings',
                name: 'Settings',
                meta: {
                    title: '系统设置',
                    node: 'admin.settings'
                },
                children: [
                    {
                        path: 'account',
                        name: 'Account',
                        meta: {
                            title: '账号管理',
                            node: 'admin.settings.account'
                        },
                        component: Account
                    },
                    {
                        path: 'role',
                        name: 'Role',
                        meta: {
                            title: '角色管理',
                            node: 'admin.settings.role'
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
                path: 'policy/edit',
                name: 'EditPolicy',
                meta: {
                    title: '编辑政务信息',
                    node: 'admin.policy.edit',
                },
                component: () => import('@/pages/policy/components/edit')
            }, */
            /* {
                path: 'finance',
                name: 'Finance',
                meta: {
                    title: '金融服务',
                    node: 'admin.finance'
                },
                component: () => import('@/pages/finance')
            }, */
            /* {
                path: 'finance/create',
                name: 'CreateFinance',
                meta: {
                    title: '新增金融服务',
                    node: 'admin.finance.create'
                },
                component: () => import('@/pages/finance/components/create')
            }, */
            /* {
                path: 'finance/edit',
                name: 'EditFinance',
                meta: {
                    title: '编辑金融服务',
                    node: 'admin.finance.edit'
                },
                component: () => import('@/pages/finance/components/edit')
            }, */
            /* {
                path: 'special',
                name: 'Special',
                meta: {
                    title: '特色专题',
                    node: 'admin.special'
                },
                component: () => import('@/pages/special')
            }, */
            /* {
                path: 'special/create',
                name: 'CreateSpecial',
                meta: {
                    title: '新增特色专题',
                    node: 'admin.special.create'
                },
                component: () => import('@/pages/special/components/create')
            }, */
            /* {
                path: 'special/edit',
                name: 'EditSpecial',
                meta: {
                    title: '编辑特色专题',
                    node: 'admin.special.edit'
                },
                component: () => import('@/pages/special/components/edit')
            }, */
            /* {
                path: 'special/topic',
                name: 'SpecialTopic',
                meta: {
                    title: '专题信息',
                    node: 'admin.special.topic'
                },
                component: () => import('@/pages/topic')
            }, */
            /* {
                path: 'special/topic/create',
                name: 'CreateTopic',
                meta: {
                    title: '新增专题',
                    node: 'admin.special.topic.create'
                },
                component: () => import('@/pages/topic/components/create')
            }, */
            /* {
                path: 'special/topic/edit',
                name: 'EditTopic',
                meta: {
                    title: '编辑专题',
                    node: 'admin.special.topic.edit'
                },
                component: () => import('@/pages/topic/components/edit')
            }, */
            /* {
                path: 'banner',
                name: 'Banner',
                meta: {
                    title: '轮播图',
                    node: 'admin.banner'
                },
                component: () => import('@/pages/banner')
            }, */
            /* {
                path: 'banner/create',
                name: 'CreateBanner',
                meta: {
                    title: '新增轮播图信息',
                    node: 'admin.banner.create'
                },
                component: () => import('@/pages/banner/components/create')
            }, */
            /* {
                path: 'banner/edit',
                name: 'EditBanner',
                meta: {
                    title: '编辑轮播图信息',
                    node: 'admin.banner.edit'
                },
                component: () => import('@/pages/banner/components/edit')
            }, */
            /* {
                path: 'vote',
                name: 'Vote',
                meta: {
                    title: '投票活动',
                    node: 'admin.vote'
                },
                component: () => import('@/pages/vote')
            }, */
            /* {
                path: 'vote/create',
                name: 'CreateVote',
                meta: {
                    title: '新增投票活动',
                    node: 'admin.vote.create'
                },
                component: () => import('@/pages/vote/components/create')
            }, */
            /* {
                path: 'vote/edit',
                name: 'EditVote',
                meta: {
                    title: '编辑投票活动',
                    node: 'admin.vote.edit'
                },
                component: () => import('@/pages/vote/components/edit')
            }, */
            /* {
                path: 'vote/subject',
                name: 'VoteSubject',
                meta: {
                    title: '投票主体信息',
                    node: 'admin.vote.subject'
                },
                component: () => import('@/pages/subject')
            }, */
            /* {
                path: 'vote/subject/create',
                name: 'CreateVoteSubject',
                meta: {
                    title: '创建投票主体信息',
                    node: 'admin.vote.subject.create'
                },
                component: () => import('@/pages/subject/components/create')
            }, */
            /* {
                path: 'vote/subject/edit',
                name: 'EditVoteSubject',
                meta: {
                    title: '编辑投票主体信息',
                    node: 'admin.vote.subject.edit'
                },
                component: () => import('@/pages/subject/components/edit')
            }, */
            /* {
                path: 'vote/prize',
                name: 'VotePrize',
                meta: {
                    title: '投票抽奖信息',
                    node: 'admin.vote.prize'
                },
                component: () => import('@/pages/prize')
            }, */
            /* {
                path: 'vote/prize/create',
                name: 'CreateVotePrize',
                meta: {
                    title: '创建投票抽奖信息',
                    node: 'admin.vote.prize.create'
                },
                component: () => import('@/pages/prize/components/create')
            }, */
            /* {
                path: 'vote/prize/edit',
                name: 'EditVotePrize',
                meta: {
                    title: '编辑投票抽奖信息',
                    node: 'admin.vote.prize.edit'
                },
                component: () => import('@/pages/prize/components/edit')
            }, */
            /* {
                path: 'user',
                name: 'User',
                meta: {
                    title: '企业用户',
                    node: 'admin.user'
                },
                component: () => import('@/pages/user')
            }, */
            /* {
                path: 'user/details',
                name: 'UserDetails',
                meta: {
                    title: '查看主体详情',
                    node: 'admin.user.details'
                },
                component: () => import('@/pages/user/components/details')
            }, */
            /* {
                path: 'user/edit',
                name: 'EditUser',
                meta: {
                    title: '编辑主体信息',
                    node: 'admin.user.edit'
                },
                component: () => import('@/pages/user/components/edit')
            }, */
            /* {
                path: 'agency',
                name: 'Agency',
                meta: {
                    title: '服务机构',
                    node: 'admin.agency'
                },
                component: () => import('@/pages/agency')
            }, */
            /* {
                path: 'agency/details',
                name: 'AgencyDetails',
                meta: {
                    title: '服务机构详情',
                    node: 'admin.agency.details'
                },
                component: () => import('@/pages/agency/components/details')
            }, */
            /* {
                path: 'agency/edit',
                name: 'EditAgency',
                meta: {
                    title: '编辑服务机构',
                    node: 'admin.agency.edit'
                },
                component: () => import('@/pages/agency/components/edit')
            }, */
            /* {
                path: 'agency/import',
                name: 'ImportAgency',
                meta: {
                    title: '导入服务机构信息',
                    node: 'admin.agency.import'
                },
                component: () => import('@/pages/agency/components/import')
            }, */
            /* {
                path: 'delegation',
                name: 'Delegation',
                meta: {
                    title: '需求中心',
                    node: 'admin.delegation'
                },
                component: () => import('@/pages/delegation')
            }, */
            /* {
                path: 'delegation/details',
                name: 'DelegationDetails',
                meta: {
                    title: '需求详情',
                    node: 'admin.delegation.details'
                },
                component: () => import('@/pages/delegation/components/details')
            }, */
            /* {
                path: 'site',
                name: 'Site',
                meta: {
                    title: '站点设置',
                    node: 'admin.site'
                },
                component: () => import('@/pages/site')
            }, */
            /* {
                path: 'role',
                name: 'Role',
                meta: {
                    title: '角色管理',
                },
                component: () => import('@/pages/role')
            }, */
            /* {
                path: 'role/create',
                name: 'CreateRole',
                meta: {
                    title: '新增角色',
                },
                component: () => import('@/pages/role/components/create')
            }, */
            /* {
                path: 'role/edit',
                name: 'EditRole',
                meta: {
                    title: '编辑角色',
                },
                component: () => import('@/pages/role/components/edit')
            }, */
            /* {
                path: 'account',
                name: 'Account',
                meta: {
                    title: '账号管理'
                },
                component: () => import('@/pages/account')
            }, */
            /* {
                path: 'account/create',
                name: 'CreateAccount',
                meta: {
                    title: '新增账号',
                },
                component: () => import('@/pages/account/components/create')
            }, */
            /* {
                path: 'account/edit',
                name: 'EditAccount',
                meta: {
                    title: '编辑账号',
                },
                component: () => import('@/pages/account/components/edit')
            }, */
            /* {
                path: 'category',
                name: 'Category',
                meta: {
                    title: '类型管理',
                },
                component: () => import('@/pages/category')
            }, */
            /* {
                path: 'category/create',
                name: 'CreateCategory',
                meta: {
                    title: '新增类型',
                },
                component: () => import('@/pages/category/components/create')
            }, */
            /* {
                path: 'category/edit',
                name: 'EditCategory',
                meta: {
                    title: '编辑类型',
                },
                component: () => import('@/pages/category/components/edit')
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