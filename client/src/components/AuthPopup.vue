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
    clickLogin() {
      this.login.getUser();
      if (!this.login.errors.login) {
        this.$emit('clickAuth', false);
      }
    },
    clickCreate() {
      const isCreate = this.auth.createUser();
      if (isCreate) {
        this.$emit('clickAuth', false);
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
