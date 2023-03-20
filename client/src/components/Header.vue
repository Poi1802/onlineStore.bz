<template>
  <header class="header bg-neutral-900">
    <div class="container py-4 text-slate-100 flex justify-between">
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
          <li class="nav__list favorite text-xl relative">
            <div
              v-if="count > 0"
              class="count absolute text-xs font-bold right-1 bottom-1">
              {{ count }}
            </div>
            <i class="fa-sharp fa-solid fa-heart"></i>
          </li>
          <li v-if="login.user" @click="popup = true" class="nav__list cursor-pointer">
            {{ login.user.name }}
          </li>
          <li v-else @click="popup = true" class="nav__list cursor-pointer">
            Вход и регистрация
          </li>
          <li class="nav__list post">Разместить объявление</li>
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
import AuthPopup from './AuthPopup.vue';

export default {
  components: {
    AuthPopup,
  },
  data: () => ({
    count: 0,
    popup: false,
    auth: useAuthStore(),
    login: useLoginStore(),
  }),
  mounted() {
    this.login.user = JSON.parse(sessionStorage.getItem('user'));
  },
  methods: {
    clickOutside(e) {
      if (e.target === this.$refs.popupArea) {
        this.popup = false;
      }
    },
  },
};
</script>

<style lang="sass" scoped>

.nav__list
  padding: 8px
  cursor: pointer
  transition: .2s

  &:hover
    color: lighten(red, 20%)
  &:active
    transform: translateY(2px)

.favorite
  &:active
    transform: scale(115%)
.post
  background-color: #009CF0
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
</style>
