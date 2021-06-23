<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0 d-inline-block">{{translate('general.news.news')}}</h3>
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
    name: trans.translate('general.news.news'),
    components:{
        TableData,
        ButtonAdd
    },
    data(){
        return {
        items: [],
        options: '/news/new',
        currentPage: 1,
        totalRows: 0,
        perPage: 15,
        bItems: [
            {
                text: trans.translate('general.dashboard'),
                to: { name: 'dashboard' }
            },
            {
                text: trans.translate('general.news.news'),
                active: true
            }
        ],
        fields: [
            {
                key: "title",
                label: trans.translate('general.news.title'),
                sortable: true,
                sortDirection: "desc",
            },
            {
                key: "subTitle",
                label: trans.translate('general.news.subtitle'),
                sortable: true,
                sortDirection: "desc",
            },
            { key: 'actions', label: trans.translate('general.actions'), tdClass: 'action-column' }
        ],
        actions:'admin/news',
        route:'/news'
    };
  },
  created() {
      this.getNews();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getNews();
      })
  },
  methods: {
      getNews(page=1){
          axios.get("/admin/news?pages="+page)
          .then(response =>{
              this.items = response.data.data;
              this.perPage = response.data.meta.per_page;
              this.currentPage = response.data.meta.current_page;
              this.totalRows= response.data.meta.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
