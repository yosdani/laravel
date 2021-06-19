<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0 name-model">{{translate('general.neighborhoods.neighborhoods')}}</h3>
              <button-add :options="options"/>
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
export default {
    name: "Neighborhood",
    components:{
        TableData,
        ButtonAdd
    },
    data(){
        return {
        items: [],
        options: '/neighborhood/new',
        currentPage: 1,
        totalRows: 0,
        perPage: 15,
        bItems: [
            {
                text: trans.translate('general.dashboard'),

                to: { name: 'dashboard' }
            },
            {
                text: trans.translate('general.neighborhoods.neighborhoods'),
                active: true
            }
        ],
        fields: [
            {
                key: "name",
                label: trans.translate('general.name'),
                sortable: true,
                sortDirection: "desc",
            },
           { key: 'actions', label: trans.translate('general.actions')}
        ],
        actions:'admin/neighborhood',
        route:'/neighborhood'
    };
  },
  created() {
      this.getNeighborhood();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getNeighborhood();
      })
  },
  methods: {
      getNeighborhood(page=1){
          axios.get("/admin/neighborhood?pages="+page)
          .then(response =>{
            this.items = response.data.neighborhood.data;
            this.perPage = response.data.neighborhood.per_page;
            this.currentPage = response.data.neighborhood.current_page;
            this.totalRows= response.data.neighborhood.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
