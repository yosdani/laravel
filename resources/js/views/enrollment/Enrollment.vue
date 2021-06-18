<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">{{translate('general.enrolments.enrolments')}}</h3>
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
    name: "Matriculas",
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
                text: 'Matriculas',
                active: true
            }
        ],
        fields: [
            {
                key: "name",
                label: "Matricula",
                sortable: true,
                sortDirection: "desc",
            },
           { key: 'actions', label: trans.translate('general.actions')}
        ],
        actions:'admin/enrollment',
        route:'/enrollment'
    };
  },
  created() {
      this.getEnrollment();
  },
  mounted() {
      EventBus.$on('DELETED_ITEM_'+this.route,() =>{
          this.getEnrollment();
      })
  },
  methods: {
      getEnrollment(page=1){
          axios.get("/admin/enrollment?pages="+page)
          .then(response =>{
            this.items = response.data.enrollment.data;
            this.perPage = response.data.enrollment.per_page;
            this.currentPage = response.data.enrollment.current_page;
            this.totalRows= response.data.enrollment.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
