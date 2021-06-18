<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">{{translate('general.streets.streets')}}</h3>
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
export default {
    name: "States",
    components:{
        TableData
    },
    data(){
        return {
        items: [],
        currentPage: 1,
        totalRows: 0,
        perPage: 15,
        bItems: [
            {
                text: 'Dashboard',
                to: { name: 'dashboard' }
            },
            {
                text: 'Calles',
                active: true
            }
        ],
        fields: [
            {
                key: "street",
                label: "Calles",
                sortable: true,
                sortDirection: "desc",
            },
            {
                key: "number",
                label: "Número",
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
            this.items = response.data.streets.data;
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
