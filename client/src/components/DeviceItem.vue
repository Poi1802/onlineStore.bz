<template>
  <div
    class="device mt-4 gap-4 relative hover:shadow-lg duration-300 hover:bg-neutral-100">
    <div class="img relative border">
      <div
        v-if="imagesArr?.length > 1"
        @click="prevImg"
        class="left-arrow h-full absolute w-20 left-1 cursor-pointer text-gray-400 hover:text-gray-600 duration-200">
        <i class="fa-solid fa-chevron-left text-3xl mt-20"></i>
      </div>
      <router-link to="#" class="device-link m-auto flex">
        <div class="img-lists flex bg-slate-100">
          <div v-for="(img, idx) in imagesArr" class="img-list">
            <img
              :class="{ active: activeImg === idx }"
              class="device-img min-w-full h-full"
              :src="`http://onlinestore.bz/assets/devices/${img}`"
              :alt="idx" />
          </div>
        </div>
      </router-link>
      <div
        v-if="imagesArr?.length > 1"
        @click="nextImg"
        class="left-arrow h-full absolute w-20 top-0 left-40 cursor-pointer text-gray-400 hover:text-gray-600 duration-200">
        <i class="fa-solid fa-chevron-right text-3xl mt-20 ml-12"></i>
      </div>
    </div>
    <div class="device-info flex duration-300">
      <div class="info-left">
        <router-link to="#">
          <div class="device-name text-2xl text-sky-500 hover:text-red-400">
            {{ device.name }}
          </div>
        </router-link>
        <div class="device price font-bold">{{ device.price }} ₽</div>
        <div class="divece-category">{{ category?.name }}</div>
      </div>
      <div class="info-right ml-auto">
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
import { useFavoritesStore } from '../stores/favoritesStore';
import { useCategoriesStore } from '../stores/categoriesStore.js';

export default {
  props: {
    device: Object,
  },
  data: () => ({
    activeImg: 0,
    imagesArr: [],
    category: {},
    categoriesStore: useCategoriesStore(),
    favoritesStore: useFavoritesStore(),
  }),
  mounted() {
    this.imagesArr = this.device.img?.split(',');
    this.categoriesStore
      .getCategory(this.device.category_id)
      .then((fetchCat) => (this.category = fetchCat));
  },
  computed: {
    inFavorite() {
      return this.favoritesStore.favorites.device_ids?.includes(String(this.device.id));
    },
  },
  methods: {
    nextImg() {
      if (this.activeImg === this.imagesArr.length - 1) {
        this.activeImg = 0;
        return;
      }
      this.activeImg++;
    },
    prevImg() {
      if (this.activeImg === 0) {
        this.activeImg = this.imagesArr.length - 1;
        return;
      }
      this.activeImg--;
    },
  },
};
</script>

<style lang="sass" scoped>
.devices
  .device
    .active
      font-weight: 900
    &-link
      width: 230px
      height: 176px

    &-info
      width: 230px
      word-wrap: break-word
      word-break: break-all

    .img-lists
      .img-list
        .device-img
          display: none
        .active
          display: block
</style>
