<template>
  <div>
      <b-breadcrumb :items="bItems"></b-breadcrumb>
      <b-card>
          <b-card-header class="border-0">
              <h3 class="mb-0 name-model">{{translate('general.incidences.incidences')}}</h3>
              
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
import TableData from "../../components/table/TableData.vue";
import trans from '../../VueTranslation/Translation';
export default {
  data() {
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
              text: trans.translate('general.incidences.incidences'),
              active: true
          }
      ],
      fields: [
          {
              key: "name",
              label: trans.translate('general.incidences.name'),
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "description",
              label: trans.translate('general.incidences.description'),
              sortable: true,
              sortDirection: "desc",
          },
          {
              key: "location",
              label: trans.translate('general.incidences.location'),
              sortable: true,
              sortDirection: "desc",
          },
          { key: 'actions', label: trans.translate('general.actions')}
      ],
      actions:'admin/incidence',
      route:'/incidences'
    };
  },
  mounted() {
     this.fetchData();
  },
  components: {
    TableData,
    ButtonAdd
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
