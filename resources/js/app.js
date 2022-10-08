import './bootstrap';
import { createApp, h } from 'vue';
import router from "./routers";
// import store from "./store";
import App from './App.vue';
import Antd from 'ant-design-vue';
import * as allIcons from '@ant-design/icons-vue';
// import VueUeditorWrap from 'vue-ueditor-wrap';
// import AuthorizePlugin from '@/plugins/authorize';

const icons = allIcons;
const el = document.getElementById('app');
const app = createApp({
        render: () => h(App)
    })
    .use(router)
    // .use(store)
    .use(Antd);
    // .use(VueUeditorWrap)
    // .use(AuthorizePlugin);

// 全局注册 icons 组件
for (const i in icons) {
  app.component(i, icons[i]);
}
app.mount(el);