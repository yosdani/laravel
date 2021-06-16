<template>
  <div class="wrapper">
    <side-bar :show="show" :elements="listOfData"></side-bar>
    <nav-bar :show="show" @showSideBar="showSideBar()"></nav-bar>
    <div :class="navClass">
      <div class="container-fluid">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
<script>
import NavBar from "./navbar/NavBar.vue";
import sideBarLinks from "../util/sideBarLinks";
import SideBar from "./sidebar/SideBar";

export default {
  data() {
    return {
      show: true,
      listOfData: sideBarLinks,
      uri: window.origin,
      listDataShow: [],
      fields: [],
    };
  },
  props:['userAuth'],
  components: {
    SideBar,
    NavBar
  },
    created() {
        let user = window.User;
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.$store.dispatch('updateUser', user);
        this.$store.dispatch('setToken', token);
    },
    methods: {
    showSideBar() {
      this.show = !this.show;
    },
  },
  computed: {
    giveMarginBottom() {
      return "margin-bottom:10px";
    },
    navClass() {
      return true === this.show ? "main-content" : "main-content-mobile";
    },
  },
};
</script>
<style lang="scss">
@import "../../sass/_variables.scss";
.main-content {
  margin-left: $sidebar-width;
}
.main-content-mobile {
  margin-left: 0;
}
.button-side-bar {
  display: block;
  opacity: 0.96;
  height: 110px;
  position: fixed;
  direction: ltr !important;
  bottom: 40%;
  border: 0;
  width: 30px;
  background: #1aa9df;
  cursor: pointer;
  transition: box-shadow 0.1s ease-in-out;
  z-index: 1024;
  border: 1px solid #fff;
  outline: none;
  padding: 0;
}
.button-side-bar__text {
  padding: 0.25rem;
  color: #ffffff;
  display: inline-block !important;
  overflow-wrap: normal !important;
  word-break: normal !important;
  word-wrap: normal !important;
  white-space: nowrap !important;
  cursor: pointer;
  filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
  -webkit-writing-mode: vertical-lr;
  -moz-writing-mode: vertical-lr;
  -ms-writing-mode: tb-rl;
  -o-writing-mode: vertical-lr;
  writing-mode: vertical-lr;
}
</style>
