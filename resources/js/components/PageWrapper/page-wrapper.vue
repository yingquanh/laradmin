<template>
    <a-card 
        class="page-wrapper"
        :title="title"
    >
        <!-- Header Extra -->
        <template #extra>
            <slot name="extra"></slot>
        </template>
        <!-- Header Extra -->
        
        <slot></slot>
    </a-card>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
    name: 'PageWrapper',
    props: {
        title: {
            type: String,
            default: ''
        }
    },
    setup() {

    }
})
</script>

<style lang="less">
    @import './page-wrapper.less';
</style>