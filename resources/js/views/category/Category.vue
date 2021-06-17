<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">{{translate('general.categories.categories')}}</h3>
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
                text: 'Dashboard',
                to: { name: 'dashboard' }
            },
            {
                text: trans.translate('general.categories.categories'),
                active: true
            }
        ],
        fields: [
            {
                key: "name",
                label: trans.translate('general.categories.categories'),
                sortable: true,
                sortDirection: "desc",
            },
            { key: 'actions', label: trans.translate('general.actions') }
        ],
        actions:'admin/category',
        route:'/categories'
    };
  },
  created() {
      this.getCategory();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getCategory();
      })
  },
  methods: {
      getCategory(page=1){
          axios.get("/admin/category?pages="+page)
          .then(response =>{
            this.items = response.data.category.data;
            this.perPage = response.data.category.per_page;
            this.currentPage = response.data.category.current_page;
            this.totalRows= response.data.category.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
