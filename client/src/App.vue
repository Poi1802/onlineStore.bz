<template>
  <Header />
  <router-view></router-view>
</template>

<script>
import Header from './components/Header.vue';

export default {
  components: {
    Header,
  },
};
</script>

<style lang="sass">
body
  .container
    max-width: 1216px
    padding-inline: 8px
    margin-inline: auto
</style>
