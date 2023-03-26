<template>
  <h2 class="text-3xl font-bold">Избранное</h2>
  <hr class="mt-6" />
  <div v-if="!deviceIds" class="mt-4 text-xl font-semibold italic">
    Нет избранного, добавьте что-нибудь)
  </div>
  <FavoriteAds v-for="deviceId in deviceIds" :deviceId="deviceId" />
</template>

<script>
import FavoriteAds from './FavoriteAds.vue';
import { useFavoritesStore } from '../stores/favoritesStore';

export default {
  components: {
    FavoriteAds,
  },
  data: () => ({
    favoritesStore: useFavoritesStore(),
    deviceIds: [],
  }),
  mounted() {
    this.favoritesStore.getFavorites().then(() => {
      this.deviceIds = this.favoritesStore.favorites.device_ids;
      console.log(this.favoritesStore.favorites.device_ids);
    });
  },
};
</script>

<style lang="sass" scoped></style>
