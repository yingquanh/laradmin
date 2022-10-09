<template>
    <div class="sign-flow-home-page">
        <div class="sign-flow-home-page-content">
            <div class="sign-flow-home-page-left">
                <img alt="Vue logo" src="@/assets/laradmin.logo.png"/>
                <div class="system-title">
                    <h3 class="main-title">Laradmin</h3>
                    <p class="sub-title">Intellectual Property Service Platform</p>
                </div>
            </div>
            <div class="sign-flow-home-page-right">
                <div class="header" style="text-align: left;height: 60px;line-height: 60px;">
                    <span style="font-family: '微软雅黑 Bold', '微软雅黑 Regular', '微软雅黑', sans-serif;font-weight: 700;font-size: 18px;color: #666666;">用户登录 </span>
                    <span style="font-family: '微软雅黑', sans-serif;font-weight: 400;font-size: 14px;color: #999999;">USER LOGIN</span>
                </div>
                <a-form
                    class="SignForm"
                    ref="formRef"
                    :model="formState"
                    :rules="rules"
                    :label-col="{span: 0}"
                    :wrapper-col="{span: 24}"
                    @finish="onSubmit"
                >
                    <a-form-item ref="name" name="account">
                        <a-input v-model:value="formState.account" autocomplete="off" spellcheck="false" placeholder="请输入登录账号" size="large">
                            <template #prefix>
                                <UserOutlined/>
                            </template>
                        </a-input>
                    </a-form-item>
                    <a-form-item ref="password" name="password">
                        <a-input-password v-model:value="formState.password" autocomplete="off" spellcheck="false" placeholder="请输入登录密码" size="large">
                            <template #prefix>
                                <LockOutlined/>
                            </template>
                        </a-input-password>
                    </a-form-item>
                    <a-form-item ref="captcha" name="captcha" :autoLink="false">
                        <a-row :gutter="16">
                            <a-col :span="16">
                                <a-input
                                    v-model:value="formState.captcha"
                                    autocomplete="off"
                                    spellcheck="false"
                                    placeholder="请输入右侧校验码"
                                    size="large"
                                    @change="() => {$refs.captcha.onFieldChange()}"
                                >
                                    <template #prefix>
                                        <SafetyCertificateOutlined/>
                                    </template>
                                </a-input>
                            </a-col>
                            <a-col :span="8" style="padding-left: 0;">
                                <div class="captcha" @click="onRefreshCaptcha">
                                    <a-image alt=验证码 width="100%" height="50px" style="user-select: none;" :preview="false" :src="captcha"/>
                                </div>
                            </a-col>
                        </a-row>
                    </a-form-item>
                    <div style="display: flex;position: relative;top: -6px;margin-bottom: 4px;justify-content: space-between;">
                        <a-checkbox v-model:checked="formState.remember">记住密码</a-checkbox>
                        <a-tooltip>
                            <template #title>请联系客服重置登录密码<br/>电话：400-888-8888</template>
                            <span style="color: #409EFF;font-size: 14px;">忘记密码？</span>
                        </a-tooltip>
                    </div>
                    <a-form-item>
                        <a-button type="primary" size="large" :disabled="loginState" block html-type="submit">
                            <span v-if="loginState">登录中...</span>
                            <span v-else>登录</span>
                        </a-button>
                    </a-form-item>
                </a-form>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, reactive, ref, onMounted } from 'vue';
import { notification } from 'ant-design-vue';
import { UserOutlined, LockOutlined, SafetyCertificateOutlined } from '@ant-design/icons-vue';
import { useRouter } from 'vue-router';
// import { useStore } from 'vuex';
// import axios from "@/utils/axios";
// import CryptoJS from '@/utils/crypto';
// import AuthServiceAPI from '@/api/auth';
export default defineComponent({
    name: 'Login',
    components: {
        UserOutlined,
        LockOutlined,
        SafetyCertificateOutlined
    },
    setup() {
        const router = useRouter();
        // const store = useStore();
        const formRef = ref();
        const formState = reactive({
            account: '',
            password: '',
            captcha: '',
            remember: false
        });
        const rules = reactive({
            account: [{
                required: true,
                validator: async (_rule, value) => {
                    if (value === '') {
                        return Promise.reject('请填写用户账号');
                    }

                    return Promise.resolve();
                },
                trigger: 'change'
            }],
            password: [{
                required: true,
                validator: async (_rule, value) => {
                    if (value === '') {
                        return Promise.reject('请填写登录密码');
                    } else if (value.length < 6 || value.length > 24) {
                        return Promise.reject('登录密码长度为6~24个字符');
                    }

                    return Promise.resolve();
                },
                trigger: 'blur'
            }],
            captcha: [{
                required: true,
                validator: async (_rule, value) => {
                    if (value === '') {
                        return Promise.reject('请填写校验码');
                    }

                    return Promise.resolve();
                },
                trigger: 'change'
            }]
        });
        const captcha = ref(null);
        const captchaKey = ref(null);
        const loginState = ref(false);

        // 表单提交事件
        const onSubmit = () => {
            if (!loginState.value) {
                loginState.value = true;

                const { account, password, captcha, remember } = formState;

                // 初始化应用程序的 CSRF 保护
                // axios.get(`${location.origin}/sanctum/csrf-cookie`).then(response => {
                    // 网络登录请求
                    /* AuthServiceAPI.postLoginInfo({
                        account,
                        password: password != '' ? CryptoJS.encrypt(password) : '',
                        captcha,
                        remember,
                    }, {
                        'Captcha-Key': captchaKey.value,
                    }).then(res => {
                        const { errcode, errmsg, data } = res.data;
                        if (!errcode) {
                            // 登录提示
                            notification.success({
                                message: "登录成功",
                                description: "欢迎您登录知识产权服务平台",
                            });

                            store.commit('setAdminInfo', data.admins);
                            store.commit('setAdminPermission', data.permissions);

                            // 重定向页面
                            router.replace({name: 'Dashboard'});
                        } else {
                            // 失败提示
                            notification.error({
                                message: "登录失败",
                                description: errmsg
                            });
                        }
                    }).catch(err => {
                        console.log(err)
                    }).finally(() => {
                        
                        loginState.value = false;   // 取消登录态

                        formState.captcha = '';     // 清除表单输入的校验码

                        onReloadCaptcha();      // 重载校验码图像
                    }) */
                // })
            }
        }

        // 校验码数据重载
        const onReloadCaptcha = () => {
            /* AuthServiceAPI.getCheckCode().then(res => {
                const { errcode, data } = res.data;
                if (!errcode) {
                    captcha.value = data;
                    captchaKey.value = res.headers['captcha-key'];
                }
            }).catch(err => [
                console.log(err)
            ]) */
        }

        // 手动刷新校验码事件
        const onRefreshCaptcha = () => {
            onReloadCaptcha();  // 校验码数据重载
        }

        onMounted(async () => {
            captcha.value = '';
            onReloadCaptcha();  // 校验码数据重载
        });

        return {
            formRef,
            formState,
            rules,
            captcha,
            loginState,
            onRefreshCaptcha,
            onSubmit,
        }
    }
});
</script>
<style lang="less">
    @import "./login.less";
</style>