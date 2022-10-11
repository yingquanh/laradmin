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

            <header-dropdown></header-dropdown>
        </a-layout-header>
        <!-- Layout Header -->

        <a-layout has-sider>
            <!-- Layout Sider -->
            <a-layout-sider theme="light" width="200">
                <a-menu 
                    v-model:openKeys="openKeys"
                    v-model:selectedKeys="selectedKeys" 
                    theme="light" 
                    mode="inline"
                >
                    <!-- <component is="solution-outlined"></component> -->
                    <!-- <a-menu-item key="TableList">
                        <router-link :to="{name: 'TableList'}">
                            <SolutionOutlined />
                            
                            数据表格
                        </router-link>
                    </a-menu-item>
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
                    </a-sub-menu> -->

                    <template v-for="menu in menus" :key="menu.id">
                        <!-- 没有二级菜单的 -->
                        <template v-if="!menu.children.length">
                            <a-menu-item :key="menu.route">
                                <router-link :to="{name: menu.route}">
                                    <component :is="menu.icon" v-if="menu.icon"></component>
                                    {{ menu.title }}
                                </router-link>
                            </a-menu-item>
                        </template>
                        <!-- 有二级菜单的 -->
                        <template v-else>
                            <a-sub-menu :key="menu.route">
                                <template #title>
                                    <component :is="menu.icon" v-if="menu.icon"></component>
                                    {{ menu.title }}
                                </template>
                                <!-- 子菜单 -->
                                <!-- <template v-for="child in menu.children" :key="child.id">
                                    <a-menu-item :key="child.route">
                                        <router-link :to="{name: child.route}">{{ child.title }}</router-link>
                                    </a-menu-item>
                                </template> -->
                                <a-menu-item v-for="child in menu.children" :key="child.route">
                                    <router-link :to="{name: child.route}">{{ child.title }}</router-link>
                                </a-menu-item>
                            </a-sub-menu>
                        </template>
                    </template>
                </a-menu>
            </a-layout-sider>
            <!-- Layout Sider -->

            <a-layout class="layout-wrap">
                <!-- 面包屑导航 -->
                <breadcrumb :routes="breadcrumb"></breadcrumb>
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
import { defineComponent, ref, onMounted, watch } from 'vue';
import { onBeforeRouteUpdate, useRoute, useRouter } from 'vue-router';
import HeaderDropdown from './components/HeaderDropdown';
import Breadcrumb from './components/Breadcrumb';
import AuthServiceAPI from '@/services/auth';
export default defineComponent({
    name: 'DefaultLayout',
    components: {
        HeaderDropdown,
        Breadcrumb,
    },
    setup() {

        const router = useRouter();
        const route = useRoute();
        const breadcrumb = ref([]);
        const openKeys = ref([]);
        const selectedKeys = ref([]);
        const menus = ref([]);
        
        

        watch(route, (newVal) => {
            route.matched.some(route => {
                if (route.meta.parent) openKeys.value.push(route.name);
            })

            selectedKeys.value = [route.matched[route.matched.length - 1].name];

            breadcrumb.value = newVal.matched.filter(route => { return route.meta.showInbreadcrumb });
        })

        onMounted(async () => {
            console.log(router.options.routes)

            route.matched.some(route => {
                if (route.meta.parent) openKeys.value.push(route.name);
            })

            selectedKeys.value = [route.matched[route.matched.length - 1].name];

            breadcrumb.value = route.matched.filter(route => { return route.meta.showInbreadcrumb });


            AuthServiceAPI.getUserInfo().then(res => {
                console.log(res)

                const { data } = res.data;

                menus.value = data.menus;
            }).catch(err => {
                console.log(err)
            })
        })

        return {
            route,
            breadcrumb,
            menus,
            openKeys,
            selectedKeys,
        }
    }
})
</script>

<style lang="less">
    @import './sider-menu.less';
</style>