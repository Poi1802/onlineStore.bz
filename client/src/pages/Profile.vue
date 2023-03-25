<template>
  <div class="container flex">
    <div class="left-block w-1/6 mt-4">
      <div class="header">
        <div class="img-user relative">
          <img
            class="w-20 rounded-full"
            src="https://20.img.avito.st/image/1/1.GbhZ_ba2o1FvWjdXZ7Ub94hetVvn3rPT6163.cTR5yEbIBIkxTckOCsmIuN9FLCiMyjKb1xFUQ35XATg"
            alt="" />
          <i
            class="fa-solid fa-camera absolute bg-slate-200 rounded-full cursor-pointer"></i>
        </div>
        <div class="user-name mt-2 text-lg font-semibold">{{ login.user.name }}</div>
      </div>
      <div class="lists">
        <hr />
        <ul class="group-lists">
          <MyProfileLink param="ads">Мои объявления</MyProfileLink>
          <MyProfileLink param="favorites">Избранное</MyProfileLink>
        </ul>
        <hr />
        <ul class="group-lists">
          <MyProfileLink param="settings">Мои настройки</MyProfileLink>
        </ul>
        <hr />
        <ul class="group-lists">
          <span class="font-bold">Мои категории</span>
          <li class="group-list">Какая-то ката</li>
        </ul>
      </div>
    </div>
    <div class="content w-full ml-20 mt-10">
      <ProfileAds v-if="$route.params.list === 'ads'" />
      <ProfileFavorites v-if="$route.params.list === 'favorites'" />
    </div>
  </div>
</template>

<script>
import { useLoginStore } from '../stores/loginStore';
import ProfileAds from '../components/ProfileAds.vue';
import ProfileFavorites from '../components/ProfileFavorites.vue';

export default {
  components: {
    ProfileAds,
    ProfileFavorites,
  },
  data: () => ({
    login: useLoginStore(),
  }),
};
</script>

<style lang="sass" scoped>
.left-block
  .lists
    .group-lists
      margin-top: 10px
      margin-bottom: 10px
      display: flex
      flex-direction: column
      gap: 6px


  .img-user
    i
      padding: 4px
      right: 70px
      top: 54px
</style>
