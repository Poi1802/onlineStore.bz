<template>
  <div
    @click="$router.push(`/category/${id}`)"
    class="category cursor-pointer bg-neutral-200 relative rounded-lg h-24 hover:bg-neutral-300 hover:shadow-lg duration-200">
    <span class="title pt-2 px-4 block z-10">{{ name }}</span>
    <img class="cat__img absolute" :src="img" alt="" />
  </div>
</template>

<script>
export default {
  props: {
    img: String,
    name: String,
    id: Number,
  },
};
</script>

<style lang="sass" scoped>
.category
  width: fit-content
  &:active
    transform: translateY(3px)
.cat__img
  bottom: 0px
  right: 0
  border-radius: 8px
</style>
