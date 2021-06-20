<template>
  <b-sidebar
    :visible="show"
    id="sidebar1"
    bg-variant="dark"
    text-variant="light"
    :shadow="true"
    :no-close-on-route-change="true"
    :style="customSidebar"
  >
      <div class="text-center bg-white">
          <router-link class="navbar-brand" to="/">
             <img :src="logo" class="navbar-brand-img" alt="...">
          </router-link>
      </div>

    <div class="px-3 py-2">
      <div class="element-sidebar" v-for="(element, i) in elements" :key="i">
          <div v-if="element.child.length === 0" class="m-1 nav-title-sidebar">
              <b-icon v-if="element.icon" :icon="element.icon"></b-icon>
              <router-link :to="element.route" exact>  {{ element.name }}</router-link>
          </div>
        <div
          v-else
          @click="rotateIcon(i)"
          v-b-toggle="'collapse' + i"
          class="m-1 nav-title-sidebar"
        >
            <b-icon v-if="element.icon" :icon="element.icon"></b-icon>
          {{ element.name }}
          <b-icon
            icon="text-right"
            class="float-right"
            :id="'icon-sidebar-' + i"
            aria-hidden="true"
          ></b-icon>
        </div>
        <b-collapse
          v-for="(subelement, index) in element.child"
          :key="index"
          class="nav-body-sidebar"
          hide
          :id="'collapse' + i"
        >
            <b-icon v-if="subelement.icon" :icon="subelement.icon"></b-icon> <router-link :to="subelement.route" exact> {{ subelement.name }}</router-link>
        </b-collapse>
      </div>
    </div>
  </b-sidebar>
</template>
<script>
export default {
  props: ["show", "elements"],
  data() {
    return {
        rotate: false,
        logo: 'images/logo-2.png'
    };
  },
  mounted() {
    document.getElementById("sidebar1").children[0].children[1].style.display = "none";
    document.getElementById("sidebar1").classList.add("sidebar-dashboard");
  },
  methods: {
    rotateIcon(index) {
      this.rotate = !this.rotate;
      if (this.rotate)
        document.getElementById("icon-sidebar-" + index).classList.add("rotate-icon");
      else
        document.getElementById("icon-sidebar-" + index).classList.remove("rotate-icon");
    },
  },
  computed: {
    customSidebar() {
      return {
        position: "absolute",
      };
    },
  },
};
</script>
<style lang="scss">
@import "../../../sass/_variables.scss";
.nav-title-sidebar {
    font-size: 1.2rem;
    font-weight: bold;
    display: inline;
    color: white
}
.nav-body-sidebar {
    margin-left: 40px;
    font-size: 15px;
}
.element-sidebar {
    margin-left: 15px;
    margin-bottom: 15px;
}
.nav-title-sidebar a {
    color: white!important;
}
.nav-title-sidebar a:hover {
    text-decoration: none!important;
}
.nav-body-sidebar a {
    color: white!important;
    font-size: 16px;
    line-height: 1.8em;
    text-decoration: none!important;
}
.b-sidebar-outer {
    max-width: $sidebar-width;
    max-height: 100%;
    width: 100%;
    background-color: $primary;
}
.b-sidebar-outer .sidebar-dashboard {
    width: $sidebar-width;
}
.rotate-icon {
    transform: rotate(90deg);
}
.navbar-brand-img{
    width: 80px;
    height: 52px;
}
#sidebar1 {
    background-color: $primary!important;
    .b-sidebar-header{
        padding: 0 1rem!important;
    }
}

</style>
