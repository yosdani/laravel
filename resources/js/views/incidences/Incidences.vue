<template>
  <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0">Incidencias</h3>
          </b-card-header>
          <b-card-body>
              <table-data :items="items" :fields="fields" :current="currentPage" :total="totalRows" :offset="perPage"></table-data>
          </b-card-body>
      </b-card>

  </div>
</template>

<script>
import TableData from "../../components/table/TableData.vue";
export default {
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
              text: 'Incidencias',
              active: true
          }
      ],
      fields: [
          {
              key: "name",
              label: "Nombre",
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "description",
              label: "Descripcion",
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "location",
              label: "Ubicacion",
              sortable: true,
              sortDirection: "desc",
          },
      ],
    };
  },
  mounted() {
     this.fetchData();
  },
  components: {
    TableData,
  },
  methods: {
    fetchData(page=1) {
      let vm = this;
      fetch("/admin/incidences?page="+page)
        .then((response) => response.json())
        .then((response) => {
            vm.items = response.incidences.data;
            vm.perPage = response.incidences.per_page;
            vm.currentPage = response.incidences.current_page;
            vm.totalRows= response.incidences.total;
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
