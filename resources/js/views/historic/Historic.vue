<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>
        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.historic.historic')}}</h3>
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
                    :allow-delete="false"
                    :allow-edit="false"
                    :allow-show="true"
                    :last-page="lastPage"
                ></table-data>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import TableData from "../../components/table/TableData";
import EventBus from "../../components/event-bus";
import trans from "../../VueTranslation/Translation";

export default {
    data(){
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
                    text: trans.translate('general.historic.historic'),
                    active: true
                }
            ],
            fields: [
                {
                    key: "incidence",
                    label: trans.translate('general.incidences.incidence'),
                    sortable: true,
                    sortDirection: "desc",
                },
                {
                    key: "changes",
                    label: trans.translate('general.historic.field'),
                    sortable: true,
                    sortDirection: "desc",
                },
                {
                    key: "user",
                    label: trans.translate('general.users.user'),
                    sortable: true,
                    sortDirection: "desc",
                },
                {
                    key: "created_at",
                    label: trans.translate('general.date'),
                    sortable: true,
                    sortDirection: "desc",
                },
                { key: 'actions', label: trans.translate('general.actions'), tdClass: 'action-column'}
            ],
            actions: '',
            route:'/historic',
        }
    },
    components:{
        TableData
    },
    created() {
        this.getHistoric();
    },
    mounted() {
        EventBus.$on('DELETED_ITEM_'+this.route,() =>{
            this.getHistoric();
        });
    },
    watch: {
        '$route' (to, from) {
           let page = this.$route.query.page;
            this.getHistoric(page);
        }
    },
    methods: {
        getHistoric(page=1){
            axios.get("/admin/historic?page="+page)
                .then(response =>{
                    this.items = response.data.data;
                    this.perPage = response.data.meta.per_page;
                    this.currentPage = response.data.meta.current_page;
                    this.totalRows= response.data.meta.total;
                    this.lastPage = response.data.meta.last_page;
                })
        }
    }
}
</script>

<style scoped>

</style>
