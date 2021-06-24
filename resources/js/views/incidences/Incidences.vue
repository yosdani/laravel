<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>
        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0 name-model">{{translate('general.incidences.incidences')}}</h3>
                <button-export class="float-right"></button-export>
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
                    :last-page="lastPage"
                ></table-data>
            </b-card-body>
        </b-card>

    </div>
</template>

<script>
import ButtonExport from "../../components/button/ButtonExport.vue";
import TableData from "../../components/table/TableData.vue";
import trans from '../../VueTranslation/Translation';
export default {
    data() {
        return {
            items: [],
            currentPage: 1,
            totalRows: 0,
            perPage: 15,
            lastPage: 1,
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
                    key: "title",
                    label: trans.translate('general.incidences.title'),
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
                    key: "user.email",
                    label: trans.translate('general.users.user'),
                    sortable: true,
                    sortDirection: "desc",
                },
                {
                    key: "createdAt",
                    label: trans.translate('general.incidences.created'),
                    sortable: true,
                    sortDirection: "desc",
                },
                {
                    key: "state.name",
                    label: trans.translate('general.incidences.state'),
                    sortable: true,
                    sortDirection: "desc",
                },
                { key: 'actions', label: trans.translate('general.actions'), tdClass: 'action-column'}
            ],
            actions:'admin/incidence',
            route:'/incidences',
        };
    },
    mounted() {
        this.fetchData();
    },
    components: {
        TableData,
        ButtonExport
    },
    watch: {
        '$route' (to, from) {
            let page = this.$route.query.page;
            this.fetchData(page);
        }
    },
    methods: {
        fetchData(page=1) {
            let vm = this;
            axios.get("/admin/incidences?page="+page)
                .then((response) => {
                    vm.items = response.data.data;
                    vm.perPage = response.data.meta.per_page;
                    vm.currentPage = response.data.meta.current_page;
                    vm.totalRows= response.data.meta.total;
                    vm.lastPage= response.data.meta.last_page;
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
