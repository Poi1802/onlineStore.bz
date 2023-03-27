<template>
  <main class="mt-5">
    <div class="container">
      <content class="block w-10/12">
        <h2 class="text-4xl my-10 font-bold">
          Все объявления категории: <span class="underline">{{ category.name }}</span>
        </h2>
        <div
          v-if="devicesStore.devices.length === 0 && devicesStore.isLoading === false"
          class="empty text-2xl italic">
          К сожалению объявлений с этой категорией нет, создайте своё :)
        </div>
        <div class="devices flex flex-wrap gap-4">
          <DeviceItem
            v-for="device in devicesStore.devices"
            :device="device"
            :key="device.id" />
        </div>
      </content>
    </div>
  </main>
</template>

<script>
import DeviceItem from '../components/DeviceItem.vue';
import { useGetDevicesStore } from '../stores/getDevices';
import { useCategoriesStore } from '../stores/categoriesStore';

export default {
  components: {
    DeviceItem,
  },
  data: () => ({
    devicesStore: useGetDevicesStore(),
    category: {},
  }),
  mounted() {
    this.devicesStore.getCategoryDevices(this.$route.params.id);
    useCategoriesStore()
      .getCategory(this.$route.params.id)
      .then((fetchCat) => (this.category = fetchCat));
  },
  methods: {},
};
</script>

<style lang="sass" scoped></style>
