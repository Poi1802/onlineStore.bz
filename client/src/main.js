import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from './App.vue';
import router from './router';
import components from './UI';

import './style.css';

const app = createApp(App);

components.forEach((component) => {
  app.component(component.name, component);
});
app.use(createPinia());
app.use(router);

app.mount('#app');
