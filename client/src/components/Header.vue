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
          <li
            v-if="login.user.name"
            @click="popup = true"
            class="nav__list cursor-pointer">
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
      <form
        v-if="registr"
        action=""
        @submit.prevent="clickCreate"
        class="registr__form p-14 pt-10 flex flex-col">
        <div class="title font-bold text-2xl">Регистрация</div>
        <div class="input">
          <div v-if="auth.nameError" class="error-msg italic text-base text-red-500">
            Имя не может быть пустым
          </div>
          <input
            v-model="auth.name"
            :class="{ 'border-2 border-red-500': auth.nameError }"
            type="text"
            placeholder="Твоё имя" />
        </div>
        <div class="input">
          <div v-if="auth.lastNameError" class="error-msg italic text-base text-red-500">
            Фамилия не может быть пустая
          </div>
          <input
            v-model="auth.last_name"
            :class="{ 'border-2 border-red-500': auth.lastNameError }"
            type="text"
            placeholder="Твоя фамилия" />
        </div>
        <div class="input">
          <div v-if="auth.emailError" class="error-msg italic text-base text-red-500">
            Email не может быть пустым
          </div>
          <input
            v-model="auth.email"
            :class="{ 'border-2 border-red-500': auth.emailError }"
            type="email"
            placeholder="Твой email" />
        </div>
        <div class="input relative">
          <input
            v-model="auth.firstPassword"
            :class="{ 'border-2 border-red-500': auth.passwordError }"
            type="password"
            placeholder="Задайте пароль" />
        </div>
        <div class="input">
          <div v-if="auth.passwordError" class="error-msg italic text-base text-red-500">
            Пароли должны совпадать
          </div>
          <input
            v-model="auth.secondPassword"
            :class="{ 'border-2 border-red-500': auth.passwordError }"
            ref="secPass"
            type="password"
            placeholder="Повторите пароль" />
        </div>
        <div class="flex items-center mt-4">
          <button
            type="submit"
            :class="{
              disabled: auth.errors.length > 0,
            }"
            class="submit-btn p-2 w-fit rounded-xl bg-sky-500 text-white hover:bg-sky-600 active:translate-y-1 duration-300">
            Зарегестрироваться
          </button>
          <div
            @click="registr = false"
            class="registr_switch cursor-pointer ml-2 text-sky-500 hover:text-red-500">
            Уже есть аккаунт?
          </div>
        </div>
      </form>
      <form
        v-else
        action=""
        @submit.prevent="clickLogin"
        class="registr__form p-14 pt-10 flex flex-col">
        <div class="title font-bold text-2xl">Вход</div>
        <div class="input">
          <input v-model="login.email" type="email" placeholder="Email" />
        </div>
        <div class="input">
          <input v-model="login.password" type="password" placeholder="Ваш пароль" />
        </div>
        <div class="flex items-center mt-4 justify-between">
          <button
            type="submit"
            class="submit-btn p-2 w-fit rounded-xl bg-sky-500 text-white hover:bg-sky-600 active:translate-y-1 duration-300">
            Войти
          </button>
          <div
            @click="registr = true"
            class="registr_switch cursor-pointer text-sky-500 hover:text-red-500">
            Нет аккаунта?
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { useAuthStore } from '../stores/authStore.js';
import { useLoginStore } from '../stores/loginStore';

export default {
  data: () => ({
    count: 0,
    registr: false,
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
    clickLogin() {
      this.login.getUser();
      if (this.login.user) {
        this.popup = false;
      }
    },
    clickCreate() {
      const isCreate = this.auth.createUser();
      if (isCreate) {
        this.popup = false;
      }
    },
  },
  watch: {
    'auth.secondPassword'() {
      this.auth.watchError();
    },
    'auth.email'() {
      this.auth.watchError();
    },
    'auth.name'() {
      this.auth.watchError();
    },
    'auth.last_name'() {
      this.auth.watchError();
    },
    registr() {
      this.auth.watchError();
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

    .registr__form
      .input
        width: auto
        margin-top: 26px
        position: relative
        .error-msg
          position: absolute
          top: -20px
        input
          width: 100%
          padding: 10px
          border-radius: 6px
          background-color: rgb(242, 241, 240)
</style>
