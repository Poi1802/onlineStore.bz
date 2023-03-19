import { defineStore } from 'pinia';
import axios from 'axios';

export const useCategoriesStore = defineStore('categoriesStore', {
  state: () => ({
    categories: [],
  }),
  actions: {
    async getCategories() {
      const data = await axios
        .get('http://onlinestore.bz/server/categories')
        .then((res) => res.data);
      this.categories = data;
    },
  },
});
