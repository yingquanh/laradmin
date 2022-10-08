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
        :size="size"
        :sortDirections="sortDirections"
    >
        <!-- 页头 -->
        <template #title>
            <div class="header-extra">
                <slot name="headerExtra"></slot>
            </div>
            <div class="header-operate">
                <a-button type="text">
                    <template #icon>
                        <sync-outlined />
                    </template>
                </a-button>
                <a-button type="text">
                    <template #icon>
                        <setting-outlined />
                    </template>
                </a-button>
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

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
    name: 'TableWrapper',
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
        size: {
            type: String,
            default: 'default',
            validator(value: string) {
                return ['default', 'middle', 'small'].includes(value)
            }
        },
        sortDirections: {
            type: Array,
            default() {
                return ['ascend', 'descend']
            }
        },
    },
    setup() {

    }
})
</script>

<style lang="less">
    @import './index.less';
</style>