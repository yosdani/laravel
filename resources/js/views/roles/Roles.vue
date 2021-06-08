<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Roles</h3>
            </b-card-header>
            <b-card-body class="row">
                <b-card class="col-lg-4 col-md-6 card-roles" v-for="(item) in items" :key="item.id">
                    <b-card-body>
                        <b-avatar class="avatar-roles" variant="info"></b-avatar>
                        <h3 class="mb-5">{{item.name}}</h3>
                        <b-button>Clicks</b-button>
                    </b-card-body>
                </b-card>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
export default {
  data() {
    return {
      items: [],
      bItems: [
          {
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: 'Roles',
              active: true
          }
      ],
    };
  },
  mounted() {
     this.fetchData();
  },
  methods: {
    fetchData(page=1) {
      let vm = this;
      fetch("/admin/roles")
        .then((response) => response.json())
        .then((response) => {
            vm.items = response;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.avatar-roles{
    width:100px;
    height:100px;
    margin-bottom: 20px;
}
.card-roles{
    margin-left: 20px;
}
</style>