import { createRouter, createWebHistory } from 'vue-router';

import Main from '../pages/Main.vue';
import About from '../pages/About.vue';
import Category from '../pages/Category.vue';
import Registration from '../pages/Registration.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'main',
      component: Main,
    },
    {
      path: '/about',
      name: 'about',
      component: About,
    },
    {
      path: '/category/:id',
      name: 'category',
      component: Category,
    },
    {
      path: '/registration',
      name: 'registration',
      component: Registration,
    },
  ],
});

export default router;
