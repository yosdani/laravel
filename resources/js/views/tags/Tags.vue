<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">Etiquetas</h3>
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
                text: 'Etiquetas',
                active: true
            }
        ],
        fields: [
            {
                key: "name",
                label: "Etiquetas",
                sortable: true,
                sortDirection: "desc",
            },
            { key: 'actions', label: 'Acciones' }
        ],
        actions:'admin/tags',
        route:'/tags'
    };
  },
  created() {
      this.getTags();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getTags();
      })
  },
  methods: {
      getTags(page=1){
          axios.get("/admin/tags?pages="+page)
          .then(response =>{
            this.items = response.data.tags.data;
            this.perPage = response.data.tags.per_page;
            this.currentPage = response.data.tags.current_page;
            this.totalRows= response.data.tags.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
