<template>
    <a-config-provider :getPopupContainer="getPopupContainer" :locale="locale">
        <router-view/>
    </a-config-provider>
</template>
<script lang="ts">
import { defineComponent } from 'vue'
import zhCN from 'ant-design-vue/es/locale/zh_CN'
export default defineComponent({
    setup() {
        // const locale = zhCN;
        const getPopupContainer = (el, dialogContext) => {
            if (dialogContext) {
                return dialogContext.getDialogWrap();
            } else {
                return document.body;
            }
        }

        return {
            locale: zhCN,
            getPopupContainer,
        }
    }
})
</script>