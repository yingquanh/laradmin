<template>
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
</template>

<script>
import { defineComponent } from 'vue';
import AuthServiceAPI from '@/services/auth';
export default defineComponent({
    name: 'HeaderDropdown',
    setup() {

        const handleDropdownClick = event => {
            switch (event.key) {
                case "monitor":
                    router.push({path: '/'});
                    break;
                case "profile":
                    router.push({path: '/profile'});
                    break;
                case "logout":
                    AuthServiceAPI.postLogoutInfo().then(res => {
                        const { errcode, errmsg } = res.data;
                        if (!errcode) {
                            localStorage.clear();
                            router.replace({name: 'Login'});
                        } else {
                            /* notification.error({
                                message: '登出失败',
                                description: errmsg
                            }) */
                        }
                    }).catch(err => {
                        console.log(err)
                        /* notification.error({
                            message: '登出失败',
                            description: '连接故障，请稍后再试'
                        }) */
                    });
                    break;
            }
        }

        return {
            username: 'Administrator',
            handleDropdownClick,
        }
    }
})
</script>

<style lang="less">
    @import './index.less';
</style>