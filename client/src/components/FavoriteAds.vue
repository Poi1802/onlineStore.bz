<template>
  <div class="device flex h-44 mt-10 gap-4 relative">
    <div
      v-if="imagesArr?.length > 1"
      @click="prevImg"
      class="left-arrow h-full absolute w-20 left-1 cursor-pointer text-gray-400 hover:text-gray-600 duration-200">
      <i class="fa-solid fa-chevron-left text-3xl mt-20"></i>
    </div>
    <router-link
      @click="$router.push(`/singleAds/${device.id}`)"
      to="#"
      class="device-link w-60 flex">
      <div class="img-lists flex bg-slate-100 w-full rounded-xl">
        <div v-for="(img, idx) in imagesArr" class="img-list">
          <img
            :class="{ active: activeImg === idx }"
            class="device-img rounded-xl min-w-full min-h-full"
            :src="`http://onlinestore.bz/assets/devices/${img}`"
            :alt="idx" />
        </div>
      </div>
    </router-link>
    <div
      v-if="imagesArr?.length > 1"
      @click="nextImg"
      class="left-arrow h-full absolute w-20 left-40 cursor-pointer text-gray-400 hover:text-gray-600 duration-200">
      <i class="fa-solid fa-chevron-right text-3xl mt-20 ml-12"></i>
    </div>
    <div class="device-info w-1/3">
      <router-link @click="$router.push(`/singleAds/${device.id}`)" to="#">
        <div class="device-name text-2xl text-sky-500 hover:text-red-400">
          {{ device.name }}
        </div>
      </router-link>
      <div class="device price text-xl font-bold">{{ device.price }} ₽</div>
      <div class="divece-category">{{ category.name }}</div>
    </div>
    <div class="info-right flex">
      <div class="heart mx-auto">
        <i
          @click="favoritesStore.addFavorites(device.id)"
          :class="{
            'active text-red-500': inFavorite,
          }"
          style="transition: 0.3s cubic-bezier(0.5, 0, 0.5, 3)"
          class="fa-regular fa-heart text-xl mt-1 mr-2 cursor-pointer hover:text-red-500 hover:scale-110">
        </i>
      </div>
    </div>
  </div>
</template>

<script>
import { useGetDevicesStore } from '../stores/getDevices';
import { useFavoritesStore } from '../stores/favoritesStore';
import { useCategoriesStore } from '../stores/categoriesStore';

export default {
  props: {
    deviceId: String,
  },
  data: () => ({
    devicesStore: useGetDevicesStore(),
    device: {},
    activeImg: 0,
    category: {},
    categoriesStore: useCategoriesStore(),
    favoritesStore: useFavoritesStore(),
  }),
  computed: {
    imagesArr() {
      return this.device.img?.split(',');
    },
    inFavorite() {
      return this.favoritesStore.favorites.device_ids?.includes(String(this.device.id));
    },
  },
  mounted() {
    console.log(this.deviceId);
    this.devicesStore.getDevice(this.deviceId).then(() => {
      this.device = this.devicesStore.devices[0];

      this.categoriesStore
        .getCategory(this.device.category_id)
        .then((fetchCat) => (this.category = fetchCat));

      console.log(this.device);
    });
  },
  methods: {
    nextImg() {
      if (this.activeImg !== this.imagesArr.length - 1) {
        this.activeImg++;
      }
    },
    prevImg() {
      if (this.activeImg !== 0) {
        this.activeImg--;
      }
    },
  },
};
</script>

<style lang="sass" scoped>

.device
  .active
    font-weight: 900

  &-link
    width: 230px
    height: 176px

  .img-lists
    .img-list
      .device-img
        display: none
      .active
        display: block
</style>
