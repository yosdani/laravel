<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">{{translate('general.districts.districts')}}</h3>
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
           { key: 'actions', label: trans.translate('general.actions')}
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
            this.perPage = response.data.districts.per_page;
            this.currentPage = response.data.districts.current_page;
            this.totalRows= response.data.districts.total;
            response.data.districts.data.map(d =>{
                this.items.push({
                    id: d.id,
                    name: d.district
                })
            })
          })
      }
  }
}
</script>

<style scoped>

</style>
