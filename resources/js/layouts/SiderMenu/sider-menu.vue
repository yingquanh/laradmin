<template>
    <a-layout class="sider-menu">
        <!-- Layout Header -->
        <a-layout-header>
            <div class="logo" @click="() => {$router.push({name: 'Dashboard'})}">
                <img src="@/assets/laradmin.logo.png" />
                <h1>Laradmin</h1>
            </div>

            <!-- <a-menu theme="dark" mode="horizontal" v-model:selectedKeys="selectedKeys1" :style="{ lineHeight: '64px' }">
                <a-menu-item key="1">nav 1</a-menu-item>
                <a-menu-item key="2">nav 2</a-menu-item>
                <a-menu-item key="3">nav 3</a-menu-item>
            </a-menu> -->

            <div class="user-center">
                <a-dropdown overlayClassName="user-center-dropdown">
                    <div class="user-info">
                        <div class="user-avatar">
                            <a-avatar :size="32">
                                <template #icon><UserOutlined /></template>
                            </a-avatar>
                        </div>
                        
                        <span>{{ username }}</span>
                    </div>
                    <template #overlay>
                        <a-menu @click="handleDropdownClick">
                            <a-menu-item key="profile">
                                <UserOutlined />&nbsp;&nbsp;资料设置
                            </a-menu-item>
                            <a-menu-item key="profile2">
                                <UserOutlined />&nbsp;&nbsp;修改密码
                            </a-menu-item>
                            <a-menu-item key="profile3">
                                <UserOutlined />&nbsp;&nbsp;登录记录
                            </a-menu-item>
                            <a-menu-divider />
                            <a-menu-item key="logout">
                                <LogoutOutlined />&nbsp;&nbsp;退出系统
                            </a-menu-item>
                        </a-menu>
                    </template>
                </a-dropdown>
            </div>
        </a-layout-header>
        <!-- Layout Header -->

        <a-layout has-sider>
            <!-- Layout Sider -->
            <a-layout-sider theme="light" width="200">
                <a-menu 
                    v-model:openKeys="openKeys"
                    v-model:selectedKeys="selectedKeys2" 
                    theme="light" 
                    mode="inline" 
                    @openChange="siderOpenChange"
                    @select="siderMenuSelectd"
                >
                    <a-menu-item key="Policy">
                        <router-link :to="{name: 'Dashboard'}">
                            <SolutionOutlined />
                            政务服务
                        </router-link>
                    </a-menu-item>
                    <a-menu-item key="Finance">
                        <router-link :to="{name: 'Dashboard'}">
                            <BankOutlined />
                            金融服务
                        </router-link>
                    </a-menu-item>
                    <a-menu-item key="Special">
                        <router-link :to="{name: 'Dashboard'}">
                            <TeamOutlined />
                            特色专题
                        </router-link>
                    </a-menu-item>
                    <!-- <a-menu-item key="Banner">
                        <router-link :to="{name: 'Banner'}">
                            <BankOutlined />
                            轮播图
                        </router-link>
                    </a-menu-item>
                    <a-menu-item key="Vote">
                        <router-link :to="{name: 'Vote'}">
                            <TeamOutlined />
                            投票活动
                        </router-link>
                    </a-menu-item>
                    <a-menu-item key="Delegation">
                        <router-link :to="{name: 'Delegation'}">
                            <SolutionOutlined />
                            需求中心
                        </router-link>
                    </a-menu-item> -->
                    <!-- <a-sub-menu key="User">
                        <template #title>
                            <span>
                                <UserOutlined />
                                用户中心
                            </span>
                        </template>
                        <a-menu-item key="CorpUser">
                            <router-link :to="{name: 'User'}">创新主体</router-link>
                        </a-menu-item>
                        <a-menu-item key="AgencyUser">
                            <router-link :to="{name: 'Agency'}">服务机构</router-link>
                        </a-menu-item>
                    </a-sub-menu> -->
                    <a-sub-menu key="Settings">
                        <template #title>
                            <span>
                                <SettingOutlined />
                                系统设置
                            </span>
                        </template>
                        <a-menu-item key="Role">
                            <router-link :to="{name: 'Role'}">角色管理</router-link>
                        </a-menu-item>
                        <a-menu-item key="Account">
                            <router-link :to="{name: 'Account'}">账号管理</router-link>
                        </a-menu-item>
                    </a-sub-menu>
                </a-menu>
            </a-layout-sider>
            <!-- Layout Sider -->

            <a-layout class="layout-wrap">
                <!-- 面包屑导航 -->
                <a-breadcrumb>
                    <a-breadcrumb-item>系统首页</a-breadcrumb-item>
                    <a-breadcrumb-item>分类名称</a-breadcrumb-item>
                    <a-breadcrumb-item>页面标题</a-breadcrumb-item>
                </a-breadcrumb>
                <!-- 面包屑导航 -->

                <!-- 内容区域 -->
                <a-layout-content>
                    <router-view />
                </a-layout-content>
                <!-- 内容区域 -->

                <!-- <a-layout-footer class="copyright">
                    <p class="copyright">©本系统由恩享(上海)网络科技公司提供技术支持</p>
                </a-layout-footer> -->
            </a-layout>
        </a-layout>
    </a-layout>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { useRouter } from 'vue-router';
export default defineComponent({
    name: 'sider-menu',
    components: {},
    setup() {

        const router = useRouter();
        // const store = useStore();
        
        const handleDropdownClick = event => {
            switch (event.key) {
                case "monitor":
                    router.push({path: '/'});
                    break;
                case "profile":
                    router.push({path: '/profile'});
                    break;
                case "logout":
                    /* AuthServiceAPI.postLogoutInfo().then(res => {
                        const { errcode, errmsg } = res.data;
                        if (!errcode) {
                            localStorage.clear();
                            router.replace({name: 'Login'});
                        } else {
                            notification.error({
                                message: '登出失败',
                                description: errmsg
                            })
                        }
                    }).catch(err => {
                        console.log(err)
                        notification.error({
                            message: '登出失败',
                            description: '连接故障，请稍后再试'
                        })
                    }); */
                    break;
            }
        }

        const siderOpenChange = (openKeys) => {
            console.log(openKeys)
        }

        const siderMenuSelectd = (item, key, selectedKeys) => {
            console.log(item, key, selectedKeys)
        }

        return {
            username: 'Administrator',
            selectedKeys2: ref([]),
            openKeys: ref([]),
            handleDropdownClick,
            siderOpenChange,
            siderMenuSelectd,
        }
    }
})
</script>

<style lang="less">
    @import './sider-menu.less';
</style>