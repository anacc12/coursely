<template>
  <div>
    <router-view :key="$route.path"></router-view>
  </div>
</template>

<script>
import AOS from 'aos';
import 'aos/dist/aos.css';
import "../css/global.scss";

export default {
  props: ["user"],

  created() {
    this.$store.commit("setUserLoginStatus", this.user);
    AOS.init();
  }
};
</script>

<style lang="scss">
@import '../css/global.scss';
</style>
