<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">Centros Públicos</h3>
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
                text: 'Centros Públicos',
                active: true
            }
        ],
        fields: [
            {
                key: "name",
                label: "Centros Públicos",
                sortable: true,
                sortDirection: "desc",
            },
            { key: 'actions', label: 'Acciones' }
        ],
        actions:'admin/public_center',
        route:'/public_center'
    };
  },
  created() {
      this.getPublicCenter();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getPublicCenter();
      })
  },
  methods: {
      getPublicCenter(page=1){
          axios.get("/admin/public_center?pages="+page)
          .then(response =>{
            this.items = response.data.public_center.data;
            this.perPage = response.data.public_center.per_page;
            this.currentPage = response.data.public_center.current_page;
            this.totalRows= response.data.public_center.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
