<template>
    <a-table
        class="table-wrapper"
        :childrenColumnName="childrenColumnName"
        :columns="columns"
        :components="components"
        :dataSource="dataSource"
        :defaultExpandAllRows="defaultExpandAllRows"
        :defaultExpandedRowKeys="defaultExpandedRowKeys"
        :expandedRowKeys="expandedRowKeys"
        :expandedRowRender="expandedRowRender"
        :expandFixed="expandFixed"
        :expandIcon="expandIcon"
        :expandRowByClick="expandRowByClick"
        :indentSize="indentSize"
        :loading="loading"
        :locale="locale"
        :pagination="false"
        :rowClassName="(_record, index) => (index % 2 === 1 ? 'table-striped' : null)"
        :rowKey="rowKey"
        :rowSelection="rowSelection"
        :scroll="scroll"
        :showExpandColumn="showExpandColumn"
        :showHeader="showHeader"
        :size="tableSize[0]"
        :sortDirections="sortDirections"
    >
        <!-- 页头 -->
        <template #title>
            <div class="header-extra">
                <slot name="headerExtra"></slot>
            </div>
            <div class="header-operate">
                <a-tooltip title="刷新">
                    <a-button type="text" @click="onRefresh">
                        <template #icon>
                            <sync-outlined />
                        </template>
                    </a-button>
                </a-tooltip>
                <a-tooltip title="密度">
                    <a-dropdown placement="bottom" trigger="click">
                        <a-button type="text">
                            <template #icon>
                                <column-height-outlined />
                            </template>
                        </a-button>
                        <template #overlay>
                            <a-menu v-model:selectedKeys="tableSize" selectable>
                                <a-menu-item key="default">默认</a-menu-item>
                                <a-menu-item key="middle">中等</a-menu-item>
                                <a-menu-item key="small">紧凑</a-menu-item>
                            </a-menu>
                        </template>
                    </a-dropdown>
                    
                </a-tooltip>
                <a-tooltip title="列设置">
                    <a-popover title="Title" placement="bottomRight" trigger="click">
                        <template #content>
                            <p>Content</p>
                            <p>Content</p>
                        </template>
                        <a-button type="text">
                            <template #icon>
                                <setting-outlined />
                            </template>
                        </a-button>
                    </a-popover>
                </a-tooltip>
            </div>
        </template>
        <!-- 页头 -->

        <!-- 页尾 -->
        <template #footer>
            <div class="footer-extra">
                <slot name="footerExtra"></slot>
            </div>
            <div class="footer-pagination">
                <template v-if="pagination">
                    <a-pagination 
                        :current="pagination.current || 1" 
                        :pageSize="pagination.pageSize || 10"
                        :pageSizeOptions="pagination.pageSizeOptions || ['10', '20', '50', '100']"
                        :hideOnSinglePage="pagination.hideOnSinglePage || true"
                        :showLessItems="pagination.showLessItems || true"
                        :showQuickJumper="pagination.showQuickJumper || true"
                        :showSizeChanger="pagination.showSizeChanger || true"
                        :showTotal="pagination.showTotal || null"
                        :total="pagination.total || 0" 
                    />
                </template>
            </div>
        </template>
        <!-- 页尾 -->

        <!-- Ant design vue table body cell slot -->
        <template #bodyCell="{ text, record, index, column }">
            <slot name="bodyCell" :text="text" :record="record" :index="index" :column="column"></slot>
        </template>
        <!-- Ant design vue table body cell slot -->

        <!-- Ant design vue table summary slot -->
        <template #summary>
            <slot name="summary"></slot>
        </template>
        <!-- Ant design vue table summary slot -->

        <!-- Default slot -->
        <slot></slot>
        <!-- Default slot -->

    </a-table>
</template>

<script>
import { defineComponent, reactive, toRefs } from 'vue';
export default defineComponent({
    name: 'TableWrapper',
    emits: ['refresh'],
    props: {
        childrenColumnName: {
            type: String,
            default: 'children'
        },
        columns: {
            type: Array
        },
        components: {
            type: Object
        },
        dataSource: {
            type: Array
        },
        defaultExpandAllRows: {
            type: Boolean,
            default: false
        },
        defaultExpandedRowKeys: {
            type: Array
        },
        expandedRowKeys: {
            type: Array
        },
        expandedRowRender: {
            type: Function
        },
        expandFixed: {
            type: [Boolean, String],
            default: false
        },
        expandIcon: {
            type: Function
        },
        expandRowByClick: {
            type: Boolean,
            default: false
        },
        indentSize: {
            type: Number,
            default: 15
        },
        loading: {
            type: [Boolean, Object],
            default: false
        },
        locale: {
            type: Object,
            default() {
                return { filterConfirm: '确定', filterReset: '重置', emptyText: '暂无数据' }
            }
        },
        pagination: {
            type: [Boolean, Object]
        },
        rowKey: {
            type: [String, Function],
            default: 'key'
        },
        rowSelection: {
            type: Object,
            default() {
                return null
            }
        },
        scroll: {
            type: Object
        },
        showExpandColumn: {
            type: Boolean,
            default: true
        },
        showHeader: {
            type: Boolean,
            default: true
        },
        sortDirections: {
            type: Array,
            default() {
                return ['ascend', 'descend']
            }
        },
    },
    setup(_props, context) {
        const state = reactive({
            tableSize: ['default'],
        });

        const tableSize = ['default'];

        // 刷新表格
        const onRefresh = () => {
            context.emit('refresh');
        }


        return {
            ...toRefs(state),
            onRefresh,
        }
    }
})
</script>

<style lang="less">
    @import './index.less';
</style>