<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">Areas</h3>
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
    name: "Areas",
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
                text: 'Areas',
                active: true
            }
        ],
        fields: [
            {
                key: "name",
                label: "Area",
                sortable: true,
                sortDirection: "desc",
            },
            {
                key: "email",
                label: "Email Responsable",
                sortable: true,
                sortDirection: "desc",
            },
            { key: 'actions', label: 'Acciones' }
        ],
        actions:'admin/areas',
        route:'/areas'
    };
  },
  created() {
      this.getAreas();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getAreas();
      })
  },
  methods: {
      getAreas(page=1){
          axios.get("/admin/areas?pages="+page)
          .then(response =>{
            let data = response.data.areas.data;
            this.perPage = response.data.areas.per_page;
            this.currentPage = response.data.areas.current_page;
            this.totalRows= response.data.areas.total;

            data.map( d=> {
                this.items.push({
                    id: d.id,
                    name: d.name,
                    user_id: d.user_id,
                    email: d.user.email
                })
            })
          })
      }
  }
}
</script>

<style scoped>

</style>
