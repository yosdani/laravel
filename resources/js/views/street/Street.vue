<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0 d-inline-block">{{translate('general.streets.streets')}}</h3>
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
import ButtonAdd from '../../components/button/ButtonAdd.vue';
import EventBus from '../../components/event-bus';
import TableData from "../../components/table/TableData.vue";
import trans from '../../VueTranslation/Translation';
export default {
    name: "States",
    components:{
        TableData,
        ButtonAdd
    },
    data(){
        return {
        items: [],
        options: '/street/new',
        currentPage: 1,
        totalRows: 0,
        perPage: 15,
        bItems: [
            {
                text: trans.translate('general.dashboard'),
                to: { name: 'dashboard' }
            },
            {
                text: trans.translate('general.streets.streets'),
                active: true
            }
        ],
        fields: [
            {
                key: "street",
                label: trans.translate('general.streets.name'),
                sortable: true,
                sortDirection: "desc",
            },
            {
                key: "number",
                label: trans.translate('general.streets.number'),
                sortable: true,
                sortDirection: "desc",
            },
           { key: 'actions', label: trans.translate('general.actions')}
        ],
        actions:'admin/street',
        route:'/street'
    };
  },
  created() {
      this.getStreet();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getStreet();
      })
  },
  methods: {
      getStreet(page=1){
          axios.get("/admin/street?pages="+page)
          .then(response =>{
            this.items = response.data.streets;
            this.perPage = response.data.streets.per_page;
            this.currentPage = response.data.streets.current_page;
            this.totalRows= response.data.streets.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
