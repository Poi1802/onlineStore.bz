import { defineStore } from 'pinia';
import axios from 'axios';
import { useLoginStore } from './loginStore';

export const useFavoritesStore = defineStore('favorites', {
  state: () => ({
    favorites: {},
  }),
  actions: {
    async getFavorites() {
      const login = useLoginStore();

      await axios
        .get(`http://onlinestore.bz/server/favorite?user_id=${login.user.id}`)
        .then((res) => {
          this.favorites = res.data;
          this.favorites.device_ids = this.favorites.device_ids.split(',');
          console.log(this.favorites);
        });
    },
    addFavorites(deviceId) {
      const login = useLoginStore();

      if (Object.keys(this.favorites).length === 0) {
        this.favorites = {
          user_id: login.user.id,
          device_ids: [String(deviceId)],
        };

        try {
          let formData = new FormData();
          formData.append('user_id', this.favorites.user_id);
          formData.append('device_ids', this.favorites.device_ids.join());

          axios.post('http://onlinestore.bz/server/favorite/create', formData).then(() =>
            axios
              .get(
                `http://onlinestore.bz/server/favorite?user_id=${this.favorites.user_id}`
              )
              .then((res) => {
                this.favorites = res.data;
                this.favorites.device_ids = this.favorites.device_ids.split(',');
              })
          );
        } catch (error) {
          console.log(error);
        }
      } else if (
        Object.keys(this.favorites).length !== 0 &&
        !this.favorites.device_ids.includes(String(deviceId))
      ) {
        this.favorites.device_ids.push(String(deviceId));

        const updatedIds = {
          device_ids: this.favorites.device_ids.join(),
        };

        try {
          axios
            .patch(
              `http://onlinestore.bz/server/favorite/update?id=${this.favorites.id}`,
              updatedIds
            )
            .then((res) => console.log(res));
        } catch (error) {
          console.log(error);
        }
      } else if (this.favorites.device_ids?.includes(String(deviceId))) {
        this.favorites.device_ids = this.favorites.device_ids.filter(
          (id) => id !== String(deviceId)
        );

        const updatedIds = {
          device_ids: this.favorites.device_ids.join(),
        };

        try {
          axios
            .patch(
              `http://onlinestore.bz/server/favorite/update?id=${this.favorites.id}`,
              updatedIds
            )
            .then((res) => console.log(res));
        } catch (error) {
          console.log(error);
        }

        if (this.favorites.device_ids.length === 0) {
          axios
            .delete(
              `http://onlinestore.bz/server/favorite/delete?id=${this.favorites.id}`
            )
            .then((res) => {
              this.favorites = {};
              console.log(res);
            });
          return;
        }
      }
      console.log(this.favorites);
    },
  },
});
