<template>
    <page-wrapper title="角色管理">
        <query-filter v-model:value="filterState">
            <a-form-item name="keyword">
                <a-input v-model:value="filterState.keyword" allowClear autocomplete="off" placeholder="关键字: 角色名称" />
            </a-form-item>
        </query-filter>
        <table-wrapper 
            :columns="columns" 
            :dataSource="dataSource" 
            :pagination="pagination"
            :loading="loading"
            :rowSelection="{ selections: true }"
            @refresh="onloadDataList"
        >
            <template #headerExtra>
                <a-button type="primary">
                    <template #icon>
                        <plus-outlined />
                    </template>
                    新增角色
                </a-button>
                <a-button>导出数据</a-button>
            </template>
            <template #footerExtra>
                <a-button>全部选择</a-button>
                <a-button>反向选择</a-button>
                <a-button>更多操作</a-button>
            </template>

            <template #bodyCell="{ column }">

                <!-- 自定义操作单元格 -->
                <template v-if="column.dataIndex === 'operate'">
                    <a-button type="primary" size="small" ghost>
                        <template #icon><right-circle-filled /></template>详情
                    </a-button>
                    <a-button type="primary" size="small" ghost>
                        <template #icon><edit-filled /></template>编辑
                    </a-button>
                    <a-button danger size="small" ghost>
                        <template #icon><delete-filled /></template>删除
                    </a-button>
                </template>
                <!-- 自定义操作单元格 -->
            </template>
        </table-wrapper>
    </page-wrapper>
</template>

<script>
import { defineComponent, reactive, onMounted, ref } from 'vue';
import PageWrapper from '@/components/PageWrapper';
import QueryFilter from '@/components/QueryFilter';
import TableWrapper from '@/components/TableWrapper';
import RoleServiceAPI from '@/services/role';
export default defineComponent({
    name: 'Role',
    components: {
        PageWrapper,
        QueryFilter,
        TableWrapper,
    },
    setup() {
        const filterState = reactive({
            keyword: '',
        });
        const pagination = reactive({
            total: 0,
            current: 1,
            pageSize: 20,
            pageSizeOptions: ['20', '50', '100', '150'],
            showQuickJumper: true,
            showSizeChanger: true,
            showTotal: total => `总共 ${total} 条数据`
        });
        const loading = ref(false);
        const columns = [
            {
                title: '角色名称',
                dataIndex: 'role_name',
                align: 'center'
            },
            {
                title: '操作',
                dataIndex: 'operate',
                align: 'center'
            }
        ];
        const dataSource = ref([]);

        const onloadDataList = () => {
            if (!loading.value) {
                // 加锁, 防止重复请求.
                loading.value = true;

                // 网络请求
                RoleServiceAPI.getRoleList(Object.assign({
                    page: pagination.current,
                    pageSize: pagination.pageSize,
                }, filterState)).then(res => {
                    const { errcode, data } = res.data;
                    if (!errcode) {
                        dataSource.value = data.lists;
                        pagination.total = data.total;
                        pagination.current = data.page;
                        pagination.pageSize = data.pageSize;
                    }
                }).catch(err => {
                    console.log(err)
                }).finally(() => {
                    // 释放锁
                    loading.value = false;
                })
            }
        }

        onMounted(async () => {
            onloadDataList();
        })
        
        return {
            filterState,
            pagination,
            loading,
            columns,
            dataSource,
            onloadDataList,
        }
    }
})
</script>

<style lang="less">
    @import './role.less';
</style>