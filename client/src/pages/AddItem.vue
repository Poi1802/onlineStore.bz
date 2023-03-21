<template>
  <div class="container">
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
      <form @submit.prevent="" class="form-area flex flex-col gap-6 my-10">
        <div class="params flex flex-col gap-6">
          <h2 class="params-title text-2xl font-bold">Параметры</h2>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Название объявления</label>
            <input type="text" class="w-1/3" />
          </div>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Производитель</label>
            <input type="text" class="w-1/4" />
          </div>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Состояние</label>
            <input type="text" class="w-1/4" />
          </div>
        </div>
        <div class="details flex flex-col gap-6">
          <h2 class="details-title text-2xl font-bold">Подробности</h2>
          <div class="input-row name-item" style="align-items: start">
            <label class="w-1/4" for="">Описание объявление</label>
            <textarea type="text" class="w-1/3" rows="6"></textarea>
          </div>
          <div class="input-row name-item">
            <label class="w-1/4" for="">Цена</label>
            <label class="relative" for="">
              <input
                inputmode="numeric"
                data-marker="price"
                maxlength="10"
                type="numeric"
                class="w-1/2" />
              <span class="absolute top-2 right-32">₽</span>
            </label>
          </div>

          <div class="input-row name-item">
            <label class="w-1/4" for="">Фотография</label>
            <input
              @change="handlerFile"
              ref="file"
              id="input-file"
              type="file"
              class="w-1/4" />
            <label for="input-file">Click</label>
          </div>
          <button @click="uploadFile" class="border-2 w-20">Clk</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useCategoriesStore } from '../stores/categoriesStore';

export default {
  data: () => ({
    catStore: useCategoriesStore(),
    catId: '',
    file: '',
  }),
  mounted() {
    this.catStore.getCategories();
  },
  methods: {
    clickOnCat(id) {
      this.catId = id;
    },
    handlerFile() {
      this.file = this.$refs.file.files[0];
    },
    uploadFile() {
      console.log(this.file);

      let formData = new FormData();
      formData.append('img', this.file);

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
</style>
