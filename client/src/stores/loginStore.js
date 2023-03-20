import axios from 'axios';
import { defineStore } from 'pinia';

export const useLoginStore = defineStore('login', {
  state: () => ({
    email: '',
    password: '',
    user: {},
    errors: {},
  }),
  actions: {
    watchErrors() {
      if (this.email === '' && !this.errors.email) {
        this.errors.email = 'Email не может быть пустой';
      } else if (this.email !== '') {
        delete this.errors.email;
      }

      if (this.password === '' && !this.errors.password) {
        this.errors.password = 'Пароль не может быть пустым';
      } else if (this.password !== '') {
        delete this.errors.password;
      }
    },
    async getUser() {
      this.watchErrors();

      if (Object.values(this.errors).length === 0) {
        try {
          this.user = await axios
            .get(
              `http://onlinestore.bz/server/user?email="${this.email}"&password=${this.password}`
            )
            .then((res) => res.data);

          sessionStorage.setItem('user', JSON.stringify(this.user));
        } catch (error) {
          this.errors.login = 'Неправильный пароль или email';
        }
      }
    },
  },
});
