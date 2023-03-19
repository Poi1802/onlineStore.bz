import axios from 'axios';
import { defineStore } from 'pinia';

export const useLoginStore = defineStore('login', {
  state: () => ({
    email: '',
    password: '',
    user: {},
  }),
  actions: {
    async getUser() {
      this.user = await axios
        .get(
          `http://onlinestore.bz/server/user?email="${this.email}"&password=${this.password}`
        )
        .then((res) => res.data);

      sessionStorage.setItem('user', JSON.stringify(this.user));
    },
  },
});
