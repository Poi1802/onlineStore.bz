<template>
  <div v-if="login.user" class="container">
    <div class="title-add my-4 text-xl text-gray-400">Новое объявление</div>
    <hr />
    <div class="addInner mt-6">
      <div class="categories-area">
        <h3 class="text-2xl font-bold">Категория</h3>
        <ul class="categories-lists border rounded-lg mt-2 w-fit">
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
      <form @submit.prevent="addItem" class="form-area flex flex-col gap-6 my-10">
        <div class="params flex flex-col gap-6">
          <h2 class="params-title text-2xl font-bold">Параметры</h2>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Название объявления</label>
            <input v-model="nameAds" type="text" class="w-1/3" />
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
          <div class="input-row name-item" style="align-items: start">
            <label class="w-1/4" for="">Описание объявление</label>
            <textarea v-model="description" type="text" class="w-1/3" rows="6"></textarea>
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
                class="delete absolute text-lg right-0 top-0">
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
          <div class="input-row name-item">
            <label class="w-1/4" for="">Почта</label>
            <input type="email" class="w-1/4" />
          </div>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Телефон</label>
            <input v-model="phone" type="phone" inputmode="numeric" class="w-1/4" />
          </div>
        </div>
        <button
          class="border p-3 m-auto mt-6 text-white rounded-lg hover:bg-sky-600 duration-200 bg-sky-500 w-fit"
          type="submit">
          Разместить объявление
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

export default {
  data: () => ({
    catStore: useCategoriesStore(),
    catId: '',
    nameAds: '',
    brand: '',
    condit: '',
    description: '',
    price: '',
    phone: '',
    files: [],
    images: [],
    login: useLoginStore(),
  }),
  mounted() {
    this.catStore.getCategories();
  },
  methods: {
    clickOnCat(id) {
      this.catId = id;
    },
    clickDeleteImg(img) {
      this.images = this.images.filter((item) => item.name !== img);
      this.files = this.files.filter((item) => item.name !== img);
      console.log(this.files);
    },
    handlerFile() {
      this.files.push(this.$refs.file.files[0]);

      const reader = new FileReader();
      reader.onload = (e) => {
        this.images.push({ src: e.target.result, name: this.files.at(-1).name });
      };
      reader.readAsDataURL(this.files.at(-1));
    },
    addItem() {
      let formData = new FormData();
      this.files.forEach((img, idx) => {
        console.log(idx);
        formData.append(idx, img);
      });
      formData.append('name', this.nameAds);
      formData.append('category_id', this.catId);
      formData.append('user_id', this.login.user.id);
      formData.append('price', this.price);
      formData.append('description', this.description);
      formData.append('brand', this.brand);
      formData.append('condit', this.condit);
      formData.append('phone', this.phone);

      axios
        .post('http://onlinestore.bz/server/device/create', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })
        .then((res) => console.log(res))
        .catch((err) => console.log(err));
    },
  },
};
</script>

<style lang="sass" scoped>
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
</style>
