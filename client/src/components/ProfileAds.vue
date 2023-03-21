<template>
  <h2 class="text-3xl font-bold">Мои объявления</h2>
  <hr class="mt-6" />
  <div class="devices">
    <div class="device flex h-44 mt-10 gap-4">
      <router-link to="#" class="device-link">
        <div class="device-img"></div>
      </router-link>
      <div class="device-info">
        <router-link to="#">
          <div class="device-name text-2xl text-sky-500 hover:text-red-400">
            iPhone 11
          </div>
        </router-link>
        <div class="device price text-xl font-bold">12 990 Р</div>
        <div class="divece-category">Электроника</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="sass" scoped>
hr
  border-top-width: 2px
.devices
  .device
    &-link
      width: 230px
      height: 176px
    &-img
      background-image: url(http://onlinestore.bz/assets/devices/iphone.jpeg)
      border-radius: 8px
      background-position: center
      background-size: 100%
      background-repeat: no-repeat
      width: 100%
      height: 100%
</style>
