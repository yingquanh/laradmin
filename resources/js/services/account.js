import axios from '@/uitls/axios';

export default {
    /**
     * 获取账号列表数据
     * @param {*} params 
     * @returns 
     */
    getAccountList(params) {
        return new Promise((resolve, reject) => {
            axios.get('/account', {
                params: params,
            }).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },

    /**
     * 获取账号信息
     * @param {*} params 
     * @returns 
     */
    getAccountInfo(params) {
        return new Promise((resolve, reject) => {
            axios.get('/get_account_info', {
                params: params,
            }).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },

    /**
     * 提交账号信息
     * @param {*} data 
     * @returns 
     */
    postAccountInfo(data) {
        return new Promise((resolve, reject) => {
            axios.post('/create_account_info', data).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },

    /**
     * 更新账号信息
     * @param {*} data 
     * @returns 
     */
    updateAccountInfo(data) {
        return new Promise((resolve, reject) => {
            axios.put('/update_account_info', data).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },

    /**
     * 删除账号信息
     * @param {*} data 
     * @returns 
     */
    deleteAccountInfo(data) {
        return new Promise((resolve, reject) => {
            axios.delete('/delete_account_info', {
                data: data,
            }).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
}