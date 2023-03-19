import { defineStore } from 'pinia';

export const useRegistrStore = defineStore('registr', {
  state: () => ({
    name: '',
    last_name: '',
    email: '',
    firstPassword: '',
    secondPassword: '',
  }),
});
