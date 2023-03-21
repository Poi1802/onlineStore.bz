<template>
  <li
    @click="$router.push(`/profile/${param}`)"
    :class="{ 'active-list': $route.params.list === param }"
    class="group-list">
    <slot></slot>
  </li>
</template>

<script>
export default {
  name: 'MyProfileLink',
  props: {
    param: String,
  },
};
</script>

<style lang="sass" scoped>
.group-list
  transition: 0.15s ease-in-out
  font-weight: 300
  cursor: pointer
  color: rgb(14, 165, 233)
  &:hover
    color: red
.active-list
  color: black
  font-weight: 700
</style>
