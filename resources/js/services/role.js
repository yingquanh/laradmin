import axios from '@/uitls/axios';

export default {
    /**
     * 获取角色列表数据
     * @param {*} params 
     * @returns 
     */
    getRoleList(params) {
        return new Promise((resolve, reject) => {
            axios.get('/role', {
                params: params,
            }).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },

    /**
     * 获取角色信息
     * @param {*} params 
     * @returns 
     */
    getRoleInfo(params) {
        return new Promise((resolve, reject) => {
            axios.get('/get_role_info', {
                params: params,
            }).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },

    /**
     * 提交角色信息
     * @param {*} data 
     * @returns 
     */
    postRoleInfo(data) {
        return new Promise((resolve, reject) => {
            axios.post('/create_role_info', data).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },

    /**
     * 更新角色信息
     * @param {*} data 
     * @returns 
     */
    updateRoleInfo(data) {
        return new Promise((resolve, reject) => {
            axios.put('/update_role_info', data).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },

    /**
     * 删除角色信息
     * @param {*} data 
     * @returns 
     */
    deleteRoleInfo(data) {
        return new Promise((resolve, reject) => {
            axios.delete('/delete_role_info', {
                data: data,
            }).then(response => {
                resolve(response)
            }).catch(error => {
                reject(error)
            })
        })
    },
}