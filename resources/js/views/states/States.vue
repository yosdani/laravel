<template>
    <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">Estados</h3>
          </b-card-header>
          <b-card-body>
              <table-data 
                :items="items" 
                :fields="fields" 
                :current="currentPage" 
                :total="totalRows" 
                :offset="perPage"
                :actions="actions"
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
    data() {
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
              text: 'Estados',
              active: true
          }
      ],
      fields: [
          {
              key: "email",
              label: "Email",
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "name",
              label: "Nombre",
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "lastName",
              label: "Apellidos",
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "phoneNumber",
              label: "Número teléfono",
              sortable: true,
              sortDirection: "desc",
          },
          { key: 'actions', label: 'Acciones' }
      ],
      actions:'admin/users'
    };
  },
  mounted() {
      this.getStates();
  },
  methods: {
      getStates(page=1){
          let vm = this;
          axios.get('/admin/states?pages='+page)
          .then(response =>{
            vm.items = response.states.data;
            vm.perPage = response.states.per_page;
            vm.currentPage = response.states.current_page;
            vm.totalRows= response.states.total;
          })
      }
  }
}
</script>

<style scoped>

</style>
