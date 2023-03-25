<template>
  <main class="mt-5">
    <div class="container">
      <content class="block w-10/12">
        <div class="categories flex flex-wrap gap-2">
          <CategoryItem
            v-for="category in categoriesStore.categories"
            :key="category.id"
            :id="category.id"
            :img="category.img"
            :name="category.name" />
        </div>
        <h2 class="text-4xl my-10 font-bold">Все Объявления</h2>
        <div class="devices flex flex-wrap gap-4">
          <DeviceItem
            v-for="device in devicesStore.devices"
            :device="device"
            :categories="categoriesStore.categories"
            :key="device.id" />
        </div>
      </content>
    </div>
  </main>
</template>

<script>
import CategoryItem from '../components/CategoryItem.vue';
import DeviceItem from '../components/DeviceItem.vue';
import { useCategoriesStore } from '../stores/categoriesStore.js';
import { useGetDevicesStore } from '../stores/getDevices';

export default {
  components: {
    CategoryItem,
    DeviceItem,
  },
  data: () => ({
    categoriesStore: useCategoriesStore(),
    devicesStore: useGetDevicesStore(),
  }),
  created() {
    this.queryApi();
  },
  methods: {
    queryApi() {
      this.categoriesStore.getCategories().then(() => {
        this.devicesStore.getDevices();
      });
    },
  },
};
</script>

<style lang="sass" scoped></style>
