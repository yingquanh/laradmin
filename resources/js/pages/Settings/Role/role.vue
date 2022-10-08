<template>
    <page-wrapper title="角色管理">
        <query-filter v-model:value="filterState">
            <a-form-item name="type">
                <a-select v-model:value="filterState.type" allowClear autocomplete="off" placeholder="政务类型">
                    <a-select-option :value="0">资讯动态</a-select-option>
                    <a-select-option :value="1">法律法规</a-select-option>
                    <a-select-option :value="2">通知公告</a-select-option>
                </a-select>
            </a-form-item>
            <a-form-item name="keyword">
                <a-input v-model:value="filterState.keyword" allowClear autocomplete="off" placeholder="关键字: 标题" />
            </a-form-item>
            <template #expand>
                <a-form-item name="phone">
                    <a-input v-model:value="filterState.phone" allowClear autocomplete="off" placeholder="关键字: 标题" />
                </a-form-item>
                <a-form-item name="title">
                    <a-input v-model:value="filterState.title" allowClear autocomplete="off" placeholder="关键字: 标题" />
                </a-form-item>
                <a-form-item name="name">
                    <a-input v-model:value="filterState.name" allowClear autocomplete="off" placeholder="关键字: 标题" />
                </a-form-item>
                <a-form-item name="address">
                    <a-input v-model:value="filterState.address" allowClear autocomplete="off" placeholder="关键字: 标题" />
                </a-form-item>
            </template>
            
        </query-filter>
        <table-wrapper 
            :columns="columns" 
            :data-source="data" 
            :pagination="pagination"
            :loading="false"
            @refresh="onRefresh"
        >
            <template #headerExtra>
                <a-button>添加标签</a-button>
                <a-button>导出数据</a-button>
            </template>
            <template #footerExtra>
                <a-button>全部选择</a-button>
                <a-button>反向选择</a-button>
                <a-button>更多操作</a-button>
            </template>

            <template #bodyCell="{ column, record }">

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

<script lang="ts">
import { defineComponent, reactive } from 'vue';
import PageWrapper from '@/components/PageWrapper';
import QueryFilter from '@/components/QueryFilter';
import TableWrapper from '@/components/TableWrapper';
import type { TableProps, TableColumnType } from 'ant-design-vue';

interface DataType {
  key: string;
  name: string;
  age: number;
  address: string;
}

export default defineComponent({
    name: 'Role',
    components: {
        PageWrapper,
        QueryFilter,
        TableWrapper,
    },
    setup() {
        const filterState = reactive({
            type: undefined,
            keyword: '',
            phone: '',
            title: '',
            name: '',
            address: ''
        });
        const pagination = reactive({
            total: 1000,
            current: 5,
            pageSize: 20,
            pageSizeOptions: ['20', '50', '100', '150'],
            showQuickJumper: true,
            showSizeChanger: true,
            showTotal: total => `总共 ${total} 条数据`
        });

        const columns: TableColumnType<DataType>[] = [
            {
                title: 'Name',
                dataIndex: 'name',
            },
            {
                title: 'Age',
                dataIndex: 'age',
            },
            {
                title: 'Address',
                dataIndex: 'address',
            },
            {
                title: '操作',
                dataIndex: 'operate'
            }
        ];
        const data: DataType[] = [
            {
                key: '1',
                name: 'John Brown',
                age: 32,
                address: 'New York No. 1 Lake Park',
            },
            {
                key: '2',
                name: 'Jim Green',
                age: 42,
                address: 'London No. 1 Lake Park',
            },
            {
                key: '3',
                name: 'Joe Black',
                age: 32,
                address: 'Sidney No. 1 Lake Park',
            },
            {
                key: '4',
                name: 'Disabled User',
                age: 99,
                address: 'Sidney No. 1 Lake Park',
            },
        ];

        const onRefresh = () => {
            console.log('手动刷新列表')
        }
        
        return {
            filterState,
            pagination,
            data,
            columns,
            onRefresh,
        }
    }
})
</script>

<style lang="less">
    @import './role.less';
</style>