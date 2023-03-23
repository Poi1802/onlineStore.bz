import { createRouter, createWebHistory } from 'vue-router';

import Main from '../pages/Main.vue';
import About from '../pages/About.vue';
import Category from '../pages/Category.vue';
import Profile from '../pages/Profile.vue';

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
      path: '/profile/:list',
      name: 'profile',
      component: Profile,
    },
    {
      path: '/addItem',
      name: 'addItem',
      component: () => import('../pages/AddItem.vue'),
    },
    {
      path: '/editItem/:id',
      name: 'editItem',
      component: () => import('../pages/EditItem.vue'),
    },
  ],
});

export default router;
