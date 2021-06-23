<template>
  <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0 d-inline-block">{{translate('general.users.users')}}</h3>
              <RouterLink :to="route+'/new'" class="float-right">
                  <b-button variant="primary" size="sm">
                      <b-icon icon="plus-circle" aria-hidden="true"></b-icon>  {{ translate('general.add') }}
                  </b-button>
              </RouterLink>
          </b-card-header>
          <b-card-body>
              <table-data
                :items="items"
                :fields="fields"
                :current="currentPage"
                :total="totalRows"
                :offset="perPage"
                :actions="actions"
                :route="route"
              ></table-data>
          </b-card-body>
      </b-card>

  </div>
</template>

<script>
import EventBus from '../../components/event-bus';
import TableData from "../../components/table/TableData.vue";
import trans from '../../VueTranslation/Translation';
import ButtonAdd from '../../components/button/ButtonAdd.vue'
export default {
  data() {
    return {
      items: [],
      options: '/users/new',
      currentPage: 1,
      totalRows: 0,
      perPage: 15,
      bItems: [
          {
              text: trans.translate('general.dashboard'),
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.users.users'),
              active: true
          }
      ],
      fields: [
          {
              key: "email",
              label: trans.translate('general.users.email'),
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "name",
              label: trans.translate('general.users.name'),
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "lastName",
              label: trans.translate('general.users.lastName'),
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "phoneNumber",
              label: trans.translate('general.users.phone'),
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "rol",
              label: trans.translate('general.roles.role'),
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: 'actions',
              label: trans.translate('general.actions'),
              filtereable: false
          }
      ],
      actions:'admin/users',
      route:'/users'
    };
  },
  mounted() {
     this.fetchData();

     EventBus.$on('DELETED_ITEM_'+this.route,() => {
       this.fetchData();
     })
  },
  components: {
    TableData,
    ButtonAdd
  },
  methods: {
    fetchData(page=1) {
      let vm = this;
      axios.get("/admin/users?page="+page)
        .then((response) => {
          this.items = [];
            vm.perPage = response.data.users.per_page;
            vm.currentPage = response.data.users.current_page;
            vm.totalRows= response.data.users.total;
            response.data.users.data.map(user => {
              this.items.push({
                id: user.id,
                email: user.email,
                name: user.name,
                lastName: user.lastName,
                phoneNumber: user.phoneNumber,
                rol: user.user_role.length>0?user.user_role[0].name:''
              })
            })
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
