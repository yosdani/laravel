<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0 d-inline-block">{{translate('general.districts.districts')}}</h3>
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
              ></table-data>
          </b-card-body>
      </b-card>
  </div>
</template>

<script>
import ButtonAdd from '../../components/button/ButtonAdd.vue';
import EventBus from '../../components/event-bus';
import TableData from "../../components/table/TableData.vue";
export default {
    name: "States",
    components:{
        TableData,
        ButtonAdd
    },
    data(){
        return {
        items: [],
        options: '/district/new',
        currentPage: 1,
        totalRows: 0,
        perPage: 15,
        bItems: [
            {
                text: trans.translate('general.dashboard'),
                to: { name: 'dashboard' }
            },
            {
                text: 'Distritos',
                active: true
            }
        ],
        fields: [
            {
                key: "name",
                label: "Distrito",
                sortable: true,
                sortDirection: "desc",
            },
           { key: 'actions', label: trans.translate('general.actions'), tdClass: 'action-column'}
        ],
        actions:'admin/district',
        route:'/district'
    };
  },
  created() {
      this.getDistrict();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getDistrict();
      })
  },
  methods: {
      getDistrict(page=1){
          this.items = [];
          axios.get("/admin/district?pages="+page)
          .then(response =>{
              this.items = response.data.data;
              this.perPage = response.data.meta.per_page;
              this.currentPage = response.data.meta.current_page;
              this.totalRows= response.data.meta.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
