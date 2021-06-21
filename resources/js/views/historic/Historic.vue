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
                { key: 'actions', label: trans.translate('general.actions')}
            ],
            actions: '',
            route:'/historic'
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
        })
    },
    methods: {
        getHistoric(page=1){
            axios.get("/admin/historic?pages="+page)
                .then(response =>{
                    this.items = response.data.historic.data;
                    this.perPage = response.data.historic.per_page;
                    this.currentPage = response.data.historic.current_page;
                    this.totalRows= response.data.historic.total;
                    //console.log('Id ' + this.items[0].id)
                })
        }
    }
}
</script>

<style scoped>

</style>
