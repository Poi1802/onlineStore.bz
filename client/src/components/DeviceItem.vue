<template>
  <div class="device h-44 mt-10 gap-4 relative">
    <div class="img">
      <div
        v-if="imagesArr"
        @click="prevImg"
        class="left-arrow h-full absolute w-20 left-1 cursor-pointer text-gray-400 hover:text-gray-600 duration-200">
        <i class="fa-solid fa-chevron-left text-3xl mt-20"></i>
      </div>
      <router-link to="#" class="device-link flex">
        <div class="img-lists flex bg-slate-100 w-full">
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
        v-if="imagesArr"
        @click="nextImg"
        class="left-arrow h-full absolute w-20 top-0 left-40 cursor-pointer text-gray-400 hover:text-gray-600 duration-200">
        <i class="fa-solid fa-chevron-right text-3xl mt-20 ml-12"></i>
      </div>
    </div>
    <div class="device-info">
      <router-link to="#">
        <div class="device-name text-2xl text-sky-500 hover:text-red-400">
          {{ device.name }}
        </div>
      </router-link>
      <div class="device price font-bold">{{ device.price }} ₽</div>
      <div class="divece-category">{{ category.name }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    device: Object,
    categories: Array,
  },
  data: () => ({
    activeImg: 0,
    imagesArr: '',
    category: {},
  }),
  mounted() {
    this.imagesArr = this.device.img?.split(',');
    this.category = this.categories.find((cat) => cat.id === this.device.category_id);
  },
  methods: {
    nextImg() {
      if (this.activeImg !== this.imagesArr.length - 1) {
        this.activeImg++;
      }
      console.log(this.category.name);
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
