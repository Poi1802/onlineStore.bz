<template>
  <div v-if="isLoading" class="loading absolute flex min-h-screen w-full overflow-hidden">
    <svg
      class="animate-spin -ml-1 mr-3 h-5 w-5 text-white absolute"
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
    <div class="load-info absolute top-1/3 right-1/2 text-4xl text-neutral-100">
      Подождите...
    </div>
  </div>
  <div v-if="login.user" class="container">
    <div class="title-add my-4 text-xl text-gray-400">Редактирование объявления</div>
    <hr />
    <div class="addInner mt-6">
      <div class="categories-area">
        <h3 class="text-2xl font-bold">Категория</h3>
        <MyErrMsg v-if="errors.catId">{{ errors.catId }}</MyErrMsg>
        <ul
          :class="{ 'border-red-500': errors.catId }"
          class="categories-lists border rounded-lg mt-2 w-fit">
          <li
            v-for="(cat, idx) in catStore.categories"
            @click="clickOnCat(cat.id)"
            :key="cat.id"
            :class="{
              'bg-sky-300 hover:bg-sky-300': cat.id === catId,
              'hover:bg-sky-100': cat.id !== catId,
              'rounded-t-lg': idx === 0,
              'rounded-b-lg': idx === catStore.categories.length - 1,
            }"
            class="cat-list p-1 px-4 cursor-pointer">
            {{ cat.name }}
          </li>
        </ul>
      </div>
      <form @submit.prevent="editItem" class="form-area flex flex-col gap-6 my-10">
        <div class="params flex flex-col gap-6">
          <h2 class="params-title text-2xl font-bold">Параметры</h2>
          <MyErrMsg v-if="errors.nameAds">{{ errors.nameAds }}</MyErrMsg>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Название объявления</label>
            <input
              v-model="nameAds"
              :class="{ error: errors.nameAds }"
              type="text"
              class="w-1/3" />
          </div>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Производитель</label>
            <input v-model="brand" type="text" class="w-1/4" />
          </div>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Состояние</label>
            <input v-model="condit" type="text" class="w-1/4" />
          </div>
        </div>
        <div class="details flex flex-col gap-6">
          <h2 class="details-title text-2xl font-bold">Подробности</h2>
          <MyErrMsg v-if="errors.description">{{ errors.description }}</MyErrMsg>
          <div class="input-row name-item" style="align-items: start">
            <label class="w-1/4" for="">Описание объявление</label>
            <textarea
              v-model="description"
              :class="{ error: errors.description }"
              type="text"
              class="w-1/3"
              rows="6"></textarea>
          </div>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Цена</label>
            <label class="relative" for="">
              <input
                inputmode="numeric"
                v-model="price"
                data-marker="price"
                maxlength="10"
                type="numeric"
                class="w-1/2" />
              <span class="absolute top-2 right-32">₽</span>
            </label>
          </div>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Фотографии</label>
            <div
              v-for="img in images"
              class="uploaded-file flex items-center relative h-20 ml-2">
              <img class="border max-w-full max-h-full" :src="img.src" alt="" />
              <div
                @click="clickDeleteImg(img.name)"
                class="delete absolute text-lg right-0 top-0 cursor-pointer">
                <i class="fa-sharp fa-solid fa-circle-xmark"></i>
              </div>
            </div>
            <input
              @change="handlerFile"
              ref="file"
              id="input-file"
              type="file"
              class="w-1/4 hidden"
              accept="image/gif,image/png,image/jpeg,image/pjpeg,image/heic"
              data-marker="add/input"
              multiple />
            <label
              class="h-20 w-28 border ml-2 relative cursor-pointer hover:bg-neutral-100 duration-300 ease-in-out"
              for="input-file">
              <div class="camera h-full w-full"></div>
            </label>
          </div>
        </div>
        <div class="contacts flex flex-col gap-6">
          <h2 class="params-title text-2xl font-bold">Контакты</h2>
          <MyErrMsg v-if="errors.phone">{{ errors.phone }}</MyErrMsg>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Телефон</label>
            <input
              v-model="phone"
              :class="{ error: errors.phone }"
              type="phone"
              inputmode="numeric"
              class="w-1/4" />
          </div>
        </div>
        <p v-if="success" class="text-green-500 text-2xl w-fit m-auto">
          Объвление добавлено!
        </p>
        <button
          class="border flex p-3 m-auto mt-6 text-white rounded-lg hover:bg-sky-600 duration-200 bg-sky-500 w-fit"
          type="submit">
          <svg
            v-if="isLoading"
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
          Изменить объявление
        </button>
      </form>
    </div>
  </div>
  <footer class="bg-slate-200">
    <div class="footer-text m-auto w-fit p-6">
      <p>Бабито — сайт объявлений. ©Сделано с любовью Баженовым Евгением Олеговичем</p>
    </div>
  </footer>
</template>

<script>
import axios from 'axios';
import { useCategoriesStore } from '../stores/categoriesStore';
import { useLoginStore } from '../stores/loginStore';
import { useGetDevicesStore } from '../stores/getDevices';

export default {
  data: () => ({
    catStore: useCategoriesStore(),
    devicesStore: useGetDevicesStore(),
    isLoading: false,
    success: false,
    device: {},
    catId: '',
    nameAds: '',
    brand: '',
    condit: '',
    description: '',
    price: '',
    phone: '',
    files: [],
    images: [],
    errors: {},
    login: useLoginStore(),
  }),
  async mounted() {
    this.catStore.getCategories();
    this.initialDevice();
  },
  methods: {
    clickOnCat(id) {
      this.catId = id;
    },
    async initialDevice() {
      try {
        this.isLoading = true;
        await this.devicesStore.getDevices(this.login.user.id);
      } catch (error) {
        console.log(error);
      } finally {
        this.isLoading = false;
      }

      this.device = this.devicesStore.devices.find(
        (obj) => obj.id == this.$route.params.id
      );

      this.brand = this.device.brand;
      this.catId = this.device.category_id;
      this.condit = this.device.condit;
      this.description = this.device.description;
      this.nameAds = this.device.name;
      this.phone = this.device.phone;
      this.price = this.device.price;
      this.device.img.split(',').forEach((img) => {
        this.images.push({
          src: `http://onlinestore.bz/assets/devices/${img}`,
          name: img,
        });
      });
    },
    clickDeleteImg(img) {
      this.images = this.images.filter((item) => item.name !== img);
      this.files = this.files.filter((item) => item.name !== img);
      this.device.img = this.device.img
        .split(',')
        .filter((item) => item !== img)
        .join(',');
    },
    handlerFile() {
      this.files.push(this.$refs.file.files[0]);

      const reader = new FileReader();
      reader.onload = (e) => {
        this.images.push({ src: e.target.result, name: this.files.at(-1).name });
      };
      reader.readAsDataURL(this.files.at(-1));
    },
    watchErrors() {
      if (this.nameAds === '' && !this.errors.nameAds) {
        this.errors.nameAds = 'Название не может быть пустым';
      } else if (this.nameAds !== '') {
        delete this.errors.nameAds;
      }
      if (this.catId === '' && !this.errors.catId) {
        this.errors.catId = 'Выберите категорию';
      } else if (this.catId !== '') {
        delete this.errors.catId;
      }
      if (this.description === '' && !this.errors.description) {
        this.errors.description = 'Описание не может быть пустым';
      } else if (this.description !== '') {
        delete this.errors.description;
      }
      if (this.phone === '' && !this.errors.phone) {
        this.errors.phone = 'Телефон должен быть заполнен';
      } else if (this.phone !== '') {
        delete this.errors.phone;
      }
    },
    async editItem() {
      this.watchErrors();

      if (Object.values(this.errors).length > 0) {
        return;
      }
      let formData = new FormData();
      this.files.forEach((img, idx) => {
        formData.append(idx, img);
      });
      formData.append('img', this.device.img);

      const editedAds = {
        category_id: this.catId,
        name: this.nameAds,
        price: this.price,
        description: this.description,
        brand: this.brand,
        condit: this.condit,
        phone: this.phone,
        img: this.device.img,
      };

      this.isLoading = true;
      const res = await axios
        .patch(
          `http://onlinestore.bz/server/device/update?id=${this.$route.params.id}`,
          editedAds
        )
        .then((res) => res.data)
        .catch((err) => console.log(err))
        .finally(() => (this.isLoading = false));

      await axios
        .post(
          `http://onlinestore.bz/server/device/addImgToDevice?id=${this.$route.params.id}`,
          formData
        )
        .then((res) => console.log(res))
        .catch((err) => console.log(err));

      if (res.status === true) {
        this.$router.push('/profile/ads');
      }
    },
  },
};
</script>

<style lang="sass" scoped>
.loading
  background-color: rgba(0,0,0,0.5)

  .animate-spin
    right: 48%
    top:35%

.form-area
  .input-row
    display: flex
    align-items: center

    input, textarea
      border-radius: 6px
      border-color: #cccccc
      border-width: 1px
      padding: 6px
      margin-left: 10px

    .camera
      background-image: url(https://www.avito.st/remote-modules/sx-item-creator/25183259/8bb1db058a01fabddc8a.svg)
      background-repeat: no-repeat
      background-position: center

    .error
      border-color: red
</style>
