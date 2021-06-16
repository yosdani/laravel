<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">Noticias</h3>
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
    name: "News",
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
                text: 'Noticias',
                active: true
            }
        ],
        fields: [
            {
                key: "title",
                label: "Título",
                sortable: true,
                sortDirection: "desc",
            },
            {
                key: "subTitle",
                label: "Subtítulo",
                sortable: true,
                sortDirection: "desc",
            },
            { key: 'actions', label: 'Acciones' }
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
            this.items = response.data.news.data;
            this.perPage = response.data.news.per_page;
            this.currentPage = response.data.news.current_page;
            this.totalRows= response.data.news.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
