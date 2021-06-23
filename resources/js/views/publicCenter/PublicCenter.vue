<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0 d-inline-block">{{translate('general.public_centers.public_centers')}}</h3>
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
import trans from '../../VueTranslation/Translation';
export default {
    name: "PublicCenter",
    components:{
        TableData,
        ButtonAdd
    },
    data(){
        return {
        items: [],
        options: '/public_center/new',
        currentPage: 1,
        totalRows: 0,
        perPage: 15,
        bItems: [
            {
                text: trans.translate('general.dashboard'),

                to: { name: 'dashboard' }
            },
            {
                text: trans.translate('general.public_centers.public_centers'),
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
           { key: 'actions', label: trans.translate('general.actions'), tdClass: 'action-column'}
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
