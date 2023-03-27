<template>
  <main class="mt-7">
    <div class="container">
      <div
        @click="$router.push(`/category/${category.id}`)"
        class="category opacity-70 cursor-pointer hover:text-red-500">
        {{ category.name }}
      </div>
      <div class="header mt-1 flex justify-between w-7/12 text-3xl font-bold">
        <div class="name">{{ device.name }}</div>
        <div class="price">{{ device.price }} ₽</div>
      </div>
      <div
        @click="favoritesStore.addFavorites(device.id)"
        class="favorite mt-3 p-1 rounded text-sm flex items-center hover:bg-slate-50 cursor-pointer px-5 border w-fit">
        <i
          :class="{
            'active text-red-500': inFavorite,
          }"
          style="transition: 0.3s cubic-bezier(0.5, 0, 0.5, 3)"
          class="heart fa-regular fa-heart text-xl mr-2 cursor-pointer hover:text-red-500 hover:scale-110">
        </i>
        <span v-if="!inFavorite">Добавить в избранное</span>
        <span v-else>В избранном</span>
      </div>
      <div class="content flex flex-col gap-10 mt-5">
        <div class="images">
          <div class="active-img h-64">
            <img
              class="w-96 h-64 border-2"
              :src="`http://onlinestore.bz/assets/devices/${imagesArr[activeImg]}`"
              alt="" />
          </div>
          <div class="passive-imgs flex mt-2 gap-1">
            <div
              v-for="(img, idx) in imagesArr"
              @mouseenter="activeImg = idx"
              class="passive-img">
              <img
                :class="{
                  'border-blue-400': activeImg === idx,
                }"
                class="h-14 w-20 border-2 border-white"
                :src="`http://onlinestore.bz/assets/devices/${img}`"
                alt="" />
            </div>
          </div>
        </div>
        <div class="brand">
          <span class="text-2xl font-bold">Производитель:</span>
          {{ device.brand }}
        </div>
        <div class="condition">
          <span class="text-2xl font-bold">Состояние:</span>
          {{ device.condit }}
        </div>
        <div class="description">
          <div class="description-title text-2xl font-bold">Описание:</div>
          <div class="description-interior">{{ device.description }}</div>
        </div>
        <div class="contacts">
          <span class="text-2xl font-bold">Контакты</span>
          <div class="contacts-phone">
            <span>Телефон:</span>
            <span>{{ device.phone }}</span>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import { useGetDevicesStore } from '../stores/getDevices';
import { useCategoriesStore } from '../stores/categoriesStore';
import { useFavoritesStore } from '../stores/favoritesStore';

export default {
  data: () => ({
    device: {},
    category: {},
    imagesArr: [],
    favoritesStore: useFavoritesStore(),
    activeImg: 0,
  }),
  computed: {
    inFavorite() {
      return this.favoritesStore.favorites.device_ids?.includes(String(this.device.id));
    },
  },
  mounted() {
    useGetDevicesStore()
      .getDevice(this.$route.params.id)
      .then(() => {
        this.device = useGetDevicesStore().devices[0];
        this.imagesArr = this.device.img.split(',');
        console.log(this.imagesArr);
        useCategoriesStore()
          .getCategory(this.device.category_id)
          .then((fetchCat) => (this.category = fetchCat));
      });
  },
};
</script>

<style lang="sass" scoped>
.favorite
  &:hover
    .heart
      --tw-text-opacity: 1
      color: rgb(239 68 68 / var(--tw-text-opacity))
      transform: scale(1.1)
.active
  font-weight: 900
</style>
