<template>
  <div :class="navClass">
    <b-navbar toggleable="lg" type="dark" variant="primary">
      <b-tooltip target="show-target" triggers="hover">
        {{ toolTipmessage }} menu lateral
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
          <b-nav-form>
            <b-form-input size="sm" class="mr-sm-2" placeholder="Buscar"></b-form-input>
            <b-button size="sm" class="my-2 my-sm-0" type="submit">Buscar</b-button>
          </b-nav-form>
          <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template #button-content>
              <em>{{ user?user.name:''}}</em>
            </template>
            <b-dropdown-item href="#">Perfil</b-dropdown-item>
            <b-dropdown-item href="#">Salir</b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>
export default {
  props: ["show","user"],
  created() {},
  data() {
    return {};
  },
  computed: {
    navClass() {
      return true === this.show ? "navbar-wrapper" : "navbar-wrapper-mobile";
    },
    toolTipmessage() {
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
  margin-left: $sidebar-width;
}
.navbar-wrapper-mpbile {
  margin-left: 0;
}
.tgg {
  cursor: pointer;
  margin-right: 15px;
}
</style>
