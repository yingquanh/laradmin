import axios from 'axios';
// import Cookies from 'js-cookie';
import router from '@/routers';

const promiseQueues = [];
let isRefreshing = false;

/** Setup request timeout */
axios.defaults.timeout = 60000;

/** Setup request headers */
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';

// 刷新token
const refreshToken = function () {
    return new Promise((resolve, reject) => {
        axios.post('/web/refresh', {}, {
            headers: {
                // Authorization: Cookies.get('token')
            }
        }).then(res => {
            resolve(res)
        }).catch(err => {
            reject(err)
        })
    })
}

/** Http request interceptor (http请求拦截器) */
/* axios.interceptors.request.use(
    config => {
        config.headers.Authorization = Cookies.get('token');
        return config;
    },
    err => {
        return Promise.reject(err);
    }); */

// Http响应拦截器
axios.interceptors.response.use(
    response => {
        return response;
    }, error => {

        // 刷新token
        if (error.response.status === 401) {
            // const config = error.config;    // 获取当前失败的请求

            router.replace({
                name: 'Login'
            })

            /* if (!isRefreshing){
                isRefreshing = true;

                return refreshToken().then(res => {
                    const token = res.data.token_type+' '+res.data.access_token;

                    // 重置 token 信息
                    Cookies.set('token', token, {
                        expires: res.data.expires_in / 3600 / 24
                    });

                    // 重置请求 header 信息
                    config.headers.Authorization = token;

                    // 清理请求队列
                    while (promiseQueues.length){
                        promiseQueues.shift()(token)
                    }

                    return axios(config)
                }).catch(err => {
                    // 刷新 token 失败后跳转到登录页面
                    router.replace({
                        name: 'Login'
                    })
                }).finally(() => {
                    isRefreshing = false
                });
            }else{
                // 正在刷新token，返回一个未执行resolve的promise
                return new Promise((resolve) => {
                    // 将resolve放进队列，用一个函数形式来保存，等token刷新后直接执行
                    promiseQueues.push((token) => {
                        config.headers['Authorization'] = token;
                        resolve(axios(config))
                    })
                })
            } */

        }

        return Promise.reject(error);
    });

export default axios;