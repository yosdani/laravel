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
                :allow-delete="true"
                :allow-edit="true"
                :allow-show="false"
                :last-page="lastPage"
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
            lastPage: 1,
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
                    tdClass: 'action-column'
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
    watch: {
        '$route' (to, from) {
            let page = this.$route.query.page;
            this.fetchData(page);
        }
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
                    this.items = response.data.data;
                    vm.perPage = response.data.meta.per_page;
                    vm.currentPage = response.data.meta.current_page;
                    vm.totalRows= response.data.meta.total;
                    vm.lastPage = response.data.meta.last_page;
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
