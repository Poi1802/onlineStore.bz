<template>
  <header class="header bg-neutral-900">
    <div class="container text-slate-100 flex justify-between">
      <router-link to="/" class="logo text-xl cursor-pointer flex items-center gap-3">
        <i class="fa-sharp fa-solid fa-braille text-5xl"></i>
        Бабито
      </router-link>
      <nav class="nav flex text-center items-center">
        <ul class="nav__lists flex items-center gap-6">
          <router-link to="/">
            <li class="nav__list bg-">Главная</li>
          </router-link>
          <router-link to="/about">
            <li class="nav__list">О нас</li>
          </router-link>
          <li
            @click="$router.push('/profile/favorites')"
            class="nav__list favorite text-xl relative">
            <div
              v-if="countOfFavorites > 0"
              class="count absolute text-xs font-bold right-2 bottom-3">
              {{ countOfFavorites }}
            </div>
            <i class="fa-sharp fa-solid fa-heart"></i>
          </li>
          <li
            @click="$router.push('/profile/ads')"
            v-if="login.user"
            class="nav__list user cursor-pointer">
            {{ login.user.name }}
            <i class="fa-solid fa-arrow-down duration-200"></i>
            <ul class="user__options bg-neutral-900 text-slate-100 z-10">
              <li
                @click="$router.push('/profile/ads')"
                class="cabinet p-1 hover:text-red-400 duration-200">
                Личный кабинет
              </li>
              <li
                @click.stop="clickLogout"
                class="exit p-1 hover:text-red-400 duration-200 w-full">
                Выход
              </li>
            </ul>
          </li>
          <li v-else @click="popup = true" class="nav__list cursor-pointer">
            Вход и регистрация
          </li>
          <router-link v-if="login.user" to="/addItem">
            <li class="nav__list post">Разместить объявление</li>
          </router-link>
        </ul>
      </nav>
    </div>
  </header>
  <div
    v-if="popup"
    ref="popupArea"
    @click="clickOutside"
    class="registr__poppup fixed w-full top-0 h-screen z-10">
    <div class="registr__area w-fit h-fit fixed top-1/4 rounded-3xl bg-white">
      <AuthPopup @clickAuth="popup = false" />
    </div>
  </div>
</template>

<script>
import { useAuthStore } from '../stores/authStore.js';
import { useLoginStore } from '../stores/loginStore';
import { useFavoritesStore } from '../stores/favoritesStore';
import AuthPopup from './AuthPopup.vue';

export default {
  components: {
    AuthPopup,
  },
  data: () => ({
    popup: false,
    auth: useAuthStore(),
    login: useLoginStore(),
    favoritesStore: useFavoritesStore(),
  }),
  mounted() {
    this.login.user = JSON.parse(sessionStorage.getItem('user'));

    if (this.login.user) {
      this.favoritesStore.getFavorites();
    }
  },
  computed: {
    countOfFavorites() {
      return this.favoritesStore.favorites.device_ids?.length;
    },
  },
  methods: {
    clickOutside(e) {
      if (e.target === this.$refs.popupArea) {
        this.popup = false;
      }
    },
    clickLogout() {
      sessionStorage.clear();
      this.login.user = null;
      this.$router.push('/');
    },
  },
};
</script>

<style lang="sass" scoped>

.nav__list
  padding: 16px
  cursor: pointer
  transition: .2s

  &:hover
    color: lighten(red, 20%)
  &:active
    transform: translateY(2px)

.favorite
  &:hover
    transform: scale(1.1)
    transition: .3s cubic-bezier(0.5, 0, 0.5, 3)
  &:active
    transform: scale(120%)
.post
  background-color: #009CF0
  padding: 6px
  border-radius: 6px
  transition: .2s

  &:hover
    color: white
    background-color: darken(#009CF0, 2%)

.registr__poppup
  background-color: rgba(0,0,0,0.5)
  overflow: hidden

  .registr__area
    left: 40%

.user
  position: relative
  &:hover
    i
      transform: translateY(3px)
    .user__options
      display: flex
      flex-direction: column
      width: max-content
      align-items: center
      gap: 10px

  &:active
    .user__options
      z-index: 2

  .user__options
    position: absolute
    z-index: 2
    top: 56px
    right: -14px
    padding: 10px
    display: none
</style>
