<template>
  <h2 class="text-3xl font-bold">Мои объявления</h2>
  <hr class="mt-6" />
  <div class="devices">
    <Ads
      v-for="device in devicesStore.devices"
      @clickDelete="filterDevices"
      :categories="categoriesStore.categories"
      :device="device"
      :key="device.id" />
  </div>
</template>

<script>
import Ads from './Ads.vue';
import { useLoginStore } from '../stores/loginStore';
import { useGetDevicesStore } from '../stores/getDevices';
import { useCategoriesStore } from '../stores/categoriesStore';

export default {
  components: {
    Ads,
  },
  data: () => ({
    devicesStore: useGetDevicesStore(),
    login: useLoginStore(),
    categoriesStore: useCategoriesStore(),
  }),
  mounted() {
    this.devicesStore.getUserDevices(this.login.user.id);
    this.categoriesStore.getCategories();
  },
  methods: {
    filterDevices(id) {
      this.devicesStore.filterDevices(id);
    },
  },
};
</script>

<style lang="sass" scoped>
hr
  border-top-width: 2px
</style>
