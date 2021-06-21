<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0 d-inline-block">{{translate('general.tags.tags')}}</h3>
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
import EventBus from '../../components/event-bus';
import TableData from "../../components/table/TableData.vue";
import trans from '../../VueTranslation/Translation';
export default {
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
                text: trans.translate('general.tags.tags'),
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
