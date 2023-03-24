<template>
  <div class="device flex h-44 mt-10 gap-4 relative">
    <div
      @click="prevImg"
      class="left-arrow h-full absolute w-20 left-1 cursor-pointer text-gray-400 hover:text-gray-600 duration-200">
      <i class="fa-solid fa-chevron-left text-3xl mt-20"></i>
    </div>
    <router-link to="#" class="device-link flex">
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
      @click="nextImg"
      class="left-arrow h-full absolute w-20 left-40 cursor-pointer text-gray-400 hover:text-gray-600 duration-200">
      <i class="fa-solid fa-chevron-right text-3xl mt-20 ml-12"></i>
    </div>
    <div class="device-info">
      <router-link to="#">
        <div class="device-name text-2xl text-sky-500 hover:text-red-400">
          {{ device.name }}
        </div>
      </router-link>
      <div class="device price text-xl font-bold">{{ device.price }} ₽</div>
      <div class="divece-category">{{ category.name }}</div>
    </div>
    <div class="device-manage ml-52">
      <button
        @click="$router.push(`/editItem/${device.id}`)"
        class="edit block mb-4 bg-slate-200 py-1 px-8 rounded-lg hover:bg-slate-300 duration-200">
        Редактировать
      </button>
      <button
        @click="deleteAds"
        class="delete ml-6 bg-red-500 py-1 px-8 rounded-lg hover:bg-red-600 duration-200">
        Удалить
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    device: Object,
    categories: Array,
  },
  data: () => ({
    activeImg: 0,
    category: {},
  }),
  computed: {
    imagesArr() {
      return this.device.img?.split(',');
    },
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
    initCategory() {
      this.category = this.categories.find(
        (category) => category.id === this.device.category_id
      );
    },
    deleteAds() {
      if (confirm(`Хотите удалить объявление ${this.device.name}?`)) {
        this.$emit('clickDelete', this.device.id);
        axios.delete(
          `http://onlinestore.bz/server/device/delete?id=${this.device.id}&img=${this.device.img}`
        );
      }
    },
  },
  watch: {
    categories() {
      this.initCategory();
    },
  },
};
</script>

<style lang="sass" scoped>
.devices
  .device
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
