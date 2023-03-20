<template>
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
      <div v-if="auth.duplicateError" class="error-msg italic text-base text-red-500">
        Такой email уже есть
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
        class="submit-btn flex p-2 w-fit rounded-xl bg-sky-500 text-white hover:bg-sky-600 active:translate-y-1 duration-300">
        <svg
          v-if="auth.isLoading"
          class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24">
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
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
      <div v-if="login.errors.login" class="error-msg italic text-sm text-red-500">
        {{ login.errors.login }}
      </div>
      <div v-if="login.errors.email" class="error-msg italic text-sm text-red-500">
        {{ login.errors.email }}
      </div>
      <input
        v-model="login.email"
        :class="{ 'border-2 border-red-500': login.errors.email }"
        type="email"
        placeholder="Email" />
    </div>
    <div class="input">
      <div v-if="login.errors.password" class="error-msg italic text-sm text-red-500">
        {{ login.errors.password }}
      </div>
      <input
        v-model="login.password"
        :class="{ 'border-2 border-red-500': login.errors.password }"
        type="password"
        placeholder="Ваш пароль" />
    </div>
    <div class="flex items-center mt-4 justify-between">
      <button
        type="submit"
        :class="{ disabled: Object.values(login.errors).length > 0 }"
        class="submit-btn p-2 w-fit flex rounded-xl bg-sky-500 text-white hover:bg-sky-600 active:translate-y-1 duration-300">
        <svg
          v-if="login.isLoading"
          class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24">
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Войти
      </button>
      <div
        @click="registr = true"
        class="registr_switch cursor-pointer text-sky-500 hover:text-red-500">
        Нет аккаунта?
      </div>
    </div>
  </form>
</template>

<script>
import { useAuthStore } from '../stores/authStore.js';
import { useLoginStore } from '../stores/loginStore';

export default {
  data: () => ({
    count: 0,
    registr: false,
    auth: useAuthStore(),
    login: useLoginStore(),
  }),
  mounted() {
    this.login.user = JSON.parse(sessionStorage.getItem('user'));
  },
  methods: {
    async clickLogin() {
      const isGet = await this.login.getUser();

      if (isGet && !this.login.isLoading) {
        this.$emit('clickAuth');
        this.login.email = '';
        this.login.password = '';
      }
    },
    async clickCreate() {
      const isCreate = await this.auth.createUser();

      if (isCreate) {
        this.$emit('clickAuth');
      }
    },
  },
  watch: {
    'auth.secondPassword'() {
      this.auth.watchError();
    },
    'auth.email'() {
      this.auth.watchError();
      this.auth.errors = [];
    },
    'auth.name'() {
      this.auth.watchError();
    },
    'auth.last_name'() {
      this.auth.watchError();
    },
    'login.email'() {
      delete this.login.errors.login;
      this.login.watchErrors();
    },
    'login.password'() {
      delete this.login.errors.login;
      this.login.watchErrors();
    },
  },
};
</script>

<style lang="sass" scoped>
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
