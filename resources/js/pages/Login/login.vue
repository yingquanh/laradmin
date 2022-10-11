<template>
    <div class="sign-flow-page">
        <a-card>
            <div class="sign-flow-page-left">
                <div class="sign-flow-page-left-content">
                    <div class="logo">
                        <img alt="logo" src="@/assets/laradmin.logo.png"/>
                    </div>
                    <h3 class="title">Laradmin</h3>
                    <p class="sub-title">Information System Platform</p>
                </div>
            </div>
            <div class="sign-flow-page-right">
                <div class="sign-flow-page-right-content">
                    <div class="header">
                        <span>用户登录 </span>
                        <span>USER LOGIN</span>
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
                        <a-form-item name="captcha" :autoLink="false">
                            <div class="captcha-wrap">
                                <a-input
                                    v-model:value="formState.captcha"
                                    autocomplete="off"
                                    spellcheck="false"
                                    placeholder="请输入右侧校验码"
                                    size="large"
                                    :maxlength="4"
                                >
                                    <template #prefix>
                                        <SafetyCertificateOutlined/>
                                    </template>
                                </a-input>
                                <div class="captcha" @click="onReloadCaptcha">
                                    <a-image alt=验证码 :preview="false" :src="captcha"/>
                                </div>
                            </div>
                        </a-form-item>
                        <div class="remember-forgot">
                            <a-checkbox v-model:checked="formState.remember">记住密码</a-checkbox>
                            <a-tooltip>
                                <template #title>请联系管理员重置登录密码</template>
                                <span class="forgot-passwd">忘记密码？</span>
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
        </a-card>
    </div>
</template>

<script>
import { defineComponent, onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { notification } from 'ant-design-vue';
import CryptoJS from '@/utils/crypto';
import AuthServiceAPI from '@/services/auth';
export default defineComponent({
    name: 'Login',
    setup() {
        const router = useRouter();
        const formRef = ref(null);
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
                trigger: 'blur'
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
                trigger: 'blur'
            }]
        });
        const captcha = ref(null);
        const captchaKey = ref(null);
        const loginState = ref(false);

        // 校验码数据重载
        const onReloadCaptcha = () => {
            AuthServiceAPI.getCheckCode().then(res => {
                const { errcode, data } = res.data;
                if (!errcode) {
                    captcha.value = data;
                    captchaKey.value = res.headers['captcha-key'];
                }
            }).catch(err => [
                console.log(err)
            ])
        }

        const onSubmit = () => {
            if (!loginState.value) {
                loginState.value = true;

                const { account, password, captcha, remember } = formState;

                // 网络登录请求
                AuthServiceAPI.postLoginInfo({
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
                            description: "欢迎您登录本系统!",
                        });

                        // 重定向页面
                        router.replace({name: 'Home'});
                    } else {
                        // 失败提示
                        notification.error({
                            message: "登录失败",
                            description: errmsg
                        });
                    }
                }).catch(err => {
                    notification.error({
                        message: '系统未知错误',
                        description: err.message
                    })
                }).finally(() => {
                    loginState.value = false;   // 取消登录态
                    formState.captcha = '';     // 清除表单输入的校验码
                    onReloadCaptcha();          // 重载校验码图像
                })
            }
        }


        onMounted(async () => {
            onReloadCaptcha();
        })

        return {
            formRef,
            formState,
            rules,
            captcha,
            loginState,
            onReloadCaptcha,
            onSubmit,
        }
    }
})
</script>
<style lang="less">
    @import "./login.less";
</style>