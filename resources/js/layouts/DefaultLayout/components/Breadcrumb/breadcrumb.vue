<template>
    <a-breadcrumb>
        <template v-for="(route, index) in routes" :key="index">
            <a-breadcrumb-item v-if="routes.length-1 === index">
                <home-outlined v-if="!index" />
                {{ route.meta.title }}
            </a-breadcrumb-item>
            <a-breadcrumb-item v-else href="">
                <router-link :to="route.path">
                    <home-outlined v-if="!index" />
                    {{ route.meta.title }}
                </router-link>
            </a-breadcrumb-item>
        </template>
    </a-breadcrumb>
</template>

<script>
import { defineComponent } from 'vue';
export default defineComponent({
    name: 'Breadcrumb',
    props: {
        routes: {
            type: Array,
            default() {
                return []
            }
        },
    },
    setup() {
        

        return {
            
        }
    }
})
</script>

<style lang="less">
    @import './breadcrumb.less';
</style>