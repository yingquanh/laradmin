import axios from '@/utils/axios';
// import axios from 'axios';

export default {
    /**
     * 获取校验码
     * @param params
     * @returns {Promise<unknown>}
     */
     getCheckCode(params) {
        return new Promise((resolve, reject) => {
            axios.get('/captcha', {
                params: params
            }).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },

    /**
     * 提交登录信息
     * @param {*} data 
     * @param {*} headers 
     * @returns 
     */
    postLoginInfo(data, headers = {}) {
        return new Promise((resolve, reject) => {
            // 初始化应用程序的 CSRF 保护
            axios.get(`${location.origin}/sanctum/csrf-cookie`).then(response => {

                // 登录请求
                axios.post('/login', data, { 
                    headers: headers 
                }).then(res => {
                    resolve(res)
                }).catch(err => {
                    reject(err)
                })
            })
        })
    },

    /**
     * 提交登出信息
     * @param {*} data 
     * @returns 
     */
    postLogoutInfo(data) {
        return new Promise((resolve, reject) => {
            axios.post('/logout', data).then(res => {
                resolve(res)
            }).catch(err => {
                reject(err)
            })
        })
    },
}