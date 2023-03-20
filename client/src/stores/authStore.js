import axios from 'axios';
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('authorization', {
  state: () => ({
    name: '',
    last_name: '',
    email: '',
    firstPassword: '',
    secondPassword: '',
    errors: [],
  }),
  getters: {
    passwordError() {
      return this.errors.includes('passwords');
    },
    emailError() {
      return this.errors.includes('email');
    },
    nameError() {
      return this.errors.includes('name');
    },
    lastNameError() {
      return this.errors.includes('last_name');
    },
  },
  actions: {
    watchError() {
      if (this.email === '') {
        this.errors.push('email');
      } else {
        this.errors = this.errors.filter((item) => item !== 'email');
      }

      if (
        this.firstPassword !== this.secondPassword &&
        !this.errors.includes('passwords')
      ) {
        this.errors.push('passwords');
      } else if (this.firstPassword === this.secondPassword) {
        this.errors = this.errors.filter((item) => item !== 'passwords');
      }

      if (this.name === '') {
        this.errors.push('name');
      } else {
        this.errors = this.errors.filter((item) => item !== 'name');
      }

      if (this.last_name === '') {
        this.errors.push('last_name');
      } else {
        this.errors = this.errors.filter((item) => item !== 'last_name');
      }
    },
    async createUser() {
      this.watchError();

      if (this.errors.length === 0) {
        let formData = new FormData();
        formData.append('name', this.name);
        formData.append('last_name', this.last_name);
        formData.append('email', this.email);
        formData.append('password', this.firstPassword);

        const res = await axios
          .post('http://onlinestore.bz/server/user/create', formData)
          .then((res) => res.data);

        console.log(res);

        if (res.status) {
          this.name = '';
          this.last_name = '';
          this.email = '';
          this.firstPassword = '';
          this.secondPassword = '';
        } else {
          this.errors.push('registr');
        }

        return res;
      }
    },
  },
});
