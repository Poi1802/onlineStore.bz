<template>
  <main class="mt-5">
    <div class="container">
      <content class="block w-2/3">
        <div class="categories flex flex-wrap gap-2">
          <CategoryItem
            v-for="category in categoriesStore.categories"
            :key="category.id"
            :id="category.id"
            :img="category.img"
            :name="category.name" />
        </div>
      </content>
    </div>
  </main>
</template>

<script>
import CategoryItem from '../components/CategoryItem.vue';
import { useCategoriesStore } from '../stores/categoriesStore.js';

export default {
  components: {
    CategoryItem,
  },
  data: () => ({
    categoriesStore: useCategoriesStore(),
  }),
  mounted() {
    this.categoriesStore.getCategories();
  },
};
</script>

<style lang="sass" scoped></style>
