import { defineStore } from 'pinia';
import axios from 'axios';

export const useCategoriesStore = defineStore('categoriesStore', {
  state: () => ({
    categories: [],
  }),
  actions: {
    async getCategories() {
      await axios.get('http://onlinestore.bz/server/categories').then((res) => {
        this.categories = res.data;
        // console.log(this.categories);
      });
    },
    async getCategory(catId) {
      return await axios
        .get(`http://onlinestore.bz/server/category?id=${catId}`)
        .then((res) => res.data);
    },
  },
});
