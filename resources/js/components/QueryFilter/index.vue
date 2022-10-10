<template>
    <a-form 
        ref="filterRef" 
        layout="inline" 
        :model="filterState" 
        @finish="onFinish" 
        class="query-filter"
    >
        <!-- Default slot -->
        <slot></slot>
        <!-- Default slot -->

        <!-- Expand slot -->
        <template v-if="expand">
            <slot name="expand"></slot>
        </template>
        <!-- Expand slot -->
        
        <!-- Operate button -->
        <a-form-item>
            <a-button type="primary" html-type="submit">
                <template #icon><SearchOutlined /></template>查询
            </a-button>
            <a-button @click="onReset">
                <template #icon><UndoOutlined /></template>重置
            </a-button>
            <a-button v-show="slots.expand !== undefined" type="link" @click="toggleExpand">
                <template #icon><DownOutlined v-if="!expand" /><UpOutlined v-else /></template>高级筛选
            </a-button>
        </a-form-item>
        <!-- Operate button -->

    </a-form>
</template>

<script>
import { defineComponent, onMounted, reactive, ref, useSlots, watch } from "vue";
export default defineComponent({
    name: 'QueryFilter',
    props: {
        value: {
            type: Object,
            default: () => {
                return {}
            }
        },
    },
    setup(props, context) {
        const slots = useSlots();
        const filterRef = ref(null);
        const filterState = reactive({});
        const expand = ref(false);

        watch(() => props.value, (newVal, oldVal) => {
            Object.assign(filterState, newVal);
        })
        

        // 提交
        const onFinish = () => {

        }

        // 重置
        const onReset = () => {
            console.log('debug', filterState)
            filterRef.value.resetFields();
            context.emit('update:value', filterState);
            context.emit('on-reset-filter');
        }

        // 切换高级筛选
        const toggleExpand = () => {
            expand.value = !expand.value;
        }

        onMounted(() => {
            
        })

        return {
            slots,
            filterRef,
            filterState,
            expand,
            onFinish,
            onReset,
            toggleExpand,
        }
    }
})
</script>

<style lang="less">
    @import './index.less';
</style>