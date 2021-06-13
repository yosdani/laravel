<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">Estados</h3>
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
                text: 'Estados',
                active: true
            }
        ],
        fields: [
            {
                key: "name",
                label: "Estado",
                sortable: true,
                sortDirection: "desc",
            },
            { key: 'actions', label: 'Acciones' }
        ],
        actions:'admin/states',
        route:'/states'
    };
  },
  created() {
      this.getStates();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getStates();
      })
  },
  methods: {
      getStates(page=1){
          axios.get("/admin/states?pages="+page)
          .then(response =>{
            this.items = response.data.states.data;
            this.perPage = response.data.states.per_page;
            this.currentPage = response.data.states.current_page;
            this.totalRows= response.data.states.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
