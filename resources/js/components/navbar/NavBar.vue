<template>
  <div :class="navClass">
    <b-navbar toggleable="lg" type="dark">
      <b-tooltip target="show-target" triggers="hover">
        {{ toolTipMessage }} menu lateral
      </b-tooltip>
      <b-icon
        id="show-target"
        icon="layout-sidebar"
        class="text-white tgg"
        @click="toggleSidebar"
      ></b-icon>
      <b-navbar-brand href="#"></b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav> </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
            <!--   <b-nav-form>
                <b-form-input size="sm" class="mr-sm-2" placeholder="Buscar"></b-form-input>
                <b-button size="sm" class="my-2 my-sm-0" type="submit">Buscar</b-button>
              </b-nav-form>-->
              <b-nav-item-dropdown right>
                <!-- Using 'button-content' slot -->
            <template #button-content>

              <em>
                  <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" src="images/user.png" width="30">
                  </span>
                  <span class="text-white upper">{{ user.name}}</span></em>
            </template>
                  <b-dropdown-item>
                      <router-link to="/profile" class="drop-user-item">
                      <b-icon icon="person"></b-icon> Perfil</router-link></b-dropdown-item>
                  <b-dropdown-item href="/logout" class="drop-user-item">
                      <b-icon icon="box-arrow-right"></b-icon> Salir
                  </b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
import { mapState } from "vuex";

export default {
  props: ["show"],
  data() {
    return {};
  },
  computed: {
    ...mapState({
       user: state => state.user
    }),
    navClass() {
      return true === this.show ? "navbar-wrapper" : "navbar-wrapper-mobile";
    },
    toolTipMessage() {
      return this.show ? "Ocultar" : "Mostrar";
    },
  },
  methods: {
    toggleSidebar() {
      this.$emit("showSideBar");
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../sass/_variables.scss";

.navbar-wrapper {
    background-color: $primary !important;
    margin-left: $sidebar-width;
}
.navbar-wrapper-mobile {
    background-color: $primary !important;
    margin-left: 0;
}
.tgg {
    cursor: pointer;
    margin-right: 15px;
}
.upper{
    text-transform: capitalize;
}
.drop-user-item, .drop-user-item:hover{
    color: black;
    text-decoration: none;
}
</style>
