<template>
    <div style="margin-top: 20px;">
        <bar-filters 
            :filters="filters" 
            @sendTimer="getTimer($event)"
            @sendStates="getStates($event)"
            @sendTags="getTags($event)"
        />
        <bar-statistics :datas="statistics"/>
        <div class="row container-card">
            <div class="text-center myLoading" v-if="loadingBody">
                <b-spinner class="align-middle"></b-spinner>
                <strong>{{ translate('general.loading') }}</strong>
            </div>
            <div v-else class="graphics-card col-lg-8 col-md-12 col-sm-12">
                <graphic
                    class="col-lg-12 col-md-12 col-sm-12"
                />
                <graphic-radar
                    class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                />
            </div>
            <div class="list-card col-lg-3 col-md-12 col-sm-12">
                <lists />
            </div>

        </div>
    </div>
</template>
<script>
import BarFilters from "../../components/bar-filters/bar-filters.vue"
import Graphic from "./components/graphic/graphic";
import GraphicRadar from './components/graphic/graphicRadar.vue';
import BarStatistics from "./components/bar-stadistics/barStatistics"
import Accordion from "./components/listWorkers/lists"
import Lists from "./components/listWorkers/lists";
import EventBus from '../../components/event-bus';
import {mapState} from "vuex";
export default {
    data() {
        return{
            filters:{
                period:'year',
                dateInit:'',
                dateEnd:'',
                tags:[],
                states:[]
            },
            loadingBody:false,
            statistics:{ 
                total: 0,
                finished:0,
                inProgress:0,
                notAssigned:0,
            }
        }
    },
    components:{
        Lists,
        Graphic,
        BarStatistics,
        Accordion,
        BarFilters,
        GraphicRadar
    },
    created() {
        this.getFilters();
        
        this.getAllDatas( this.filters );
    },
    mounted() {
        EventBus.$on('GET_TIMER_PERIOD', payload =>{
            this.filters.dateInit = payload[0];
            this.filters.dateEnd = payload[1];

            this.getGraphicDatas( this.filters );
        });
    },
    methods: {
        getFilters(){
            axios.get(window.origin+'/admin/users/'+this.$store.state.user.id)
            .then(response => {
                if(response.data.user.filters != null)
                    this.filters.period = JSON.parse(response.data.user.filters).period;
                    this.filters.dateInit = JSON.parse(response.data.user.filters).dateInit;
                    this.filters.dateEnd = JSON.parse(response.data.user.filters).dateEnd;
                    this.filters.states = JSON.parse(response.data.user.filters).states;
                    this.filters.tags = JSON.parse(response.data.user.filters).tags;
            })
        },
        getTimer(event){
            this.filters.period = event;
            if(event != 'period'){
                this.getAllDatas( this.filters );
            }
        },
        getStates(event){
            let states = [];
            event.map( state => {
                states.push( state.id );
            })
            this.filters.states = states;
            this.getGraphicDatas( this.filters );
        },
        getTags(event){
            let tags = [];
            event.map(tag => {
                tags.push(tag.id);
            })
            this.filters.tags = tags;

            this.getAllDatas( this.filters );
        },
        getAllDatas( filters ){
            this.getStatistics( filters );
            this.getDashboardBar( filters );
            this.getDashboardRadar( filters );
            this.getDashboardTeams( filters );

            this.$store.dispatch('dataCharge');
            
        },
        getGraphicDatas( filters ){
            this.getDashboardBar( filters );
            this.getDashboardRadar( filters )

            this.$store.dispatch('dataCharge');
        },
        getStatistics( filter_time ){
            axios.post(window.origin + '/admin/dashboard/general',filter_time)
            .then(response => {
                this.statistics.total = response.data.total;
                this.statistics.finished = response.data.finished;
                this.statistics.inProgress = response.data.in_progress;
                this.statistics.notAssigned = response.data.not_assigned;
                //EventBus.$emit('GET_GENERAL_STATISTICS', response.data );
            })
        },
        getDashboardBar( filter_time ){
            axios.post(window.origin + '/admin/dashboard/bar',filter_time)
            .then(response => {
                let dataOfGraphicBar = {
                    type: "bar",
                    data: {
                        labels: response.data.areas,
                        datasets: [
                            {
                                label: trans.translate('general.total'),
                                data: response.data.totalByAreas,
                                backgroundColor: "rgba(168,255,137,.3)",
                                borderColor: "#A8FF89",
                                borderWidth: 2
                            },
                            {
                                label: trans.translate('general.incidences.finished'),
                                data: response.data.totalFinish,
                                backgroundColor: "rgba(225,193,50,.3)",
                                borderColor: "#E1C132",
                                borderWidth: 2
                            },
                            {
                                label: trans.translate('general.incidences.in_progress'),
                                data: response.data.totalInProgress,
                                backgroundColor: "rgba(96, 162,255,.3)",
                                borderColor: "#60A2FF",
                                borderWidth: 2
                            },
                            {
                                label:  trans.translate('general.incidences.not_assigned'),
                                data: response.data.totalUnsigned,
                                backgroundColor: "rgba(255, 75,99,.3)",
                                borderColor: "#FF4B63",
                                borderWidth: 2
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        lineTension: 1,
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        beginAtZero: true,
                                        padding: 25
                                    }
                                }
                            ]
                        }
                    }
                }
                EventBus.$emit('GET_DATAS_GRAPHIC_BAR', dataOfGraphicBar );
            })
        },
        getDashboardRadar( filter_time ){
            axios.post(window.origin + '/admin/dashboard/radar',filter_time)
            .then(response => {
                let dataOfGraphicRadar = {
                    type: "radar",
                    data: {
                        labels: response.data.districts,
                        datasets: [
                            {
                                label: trans.translate('general.incidences.by_district'),
                                data: response.data.incidences,
                                fill: true,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgb(255, 99, 132)',
                                pointBackgroundColor: 'rgb(255, 99, 132)',
                                pointBorderColor: '#fff',
                                pointHoverBackgroundColor: '#fff',
                                pointHoverBorderColor: 'rgb(255, 99, 132)'
                            }
                        ]
                    },
                    options: {
                        elements: {
                            line: {
                                borderWidth: 3
                            }
                        }
                    }
                }
                EventBus.$emit('GET_DATAS_GRAPHIC_RADAR', dataOfGraphicRadar );
            })
        },
        getDashboardTeams( filter_time ){
            axios.post(window.origin + '/admin/dashboard/teams',filter_time)
            .then(response => {
                EventBus.$emit('GET_DATAS_CARD_WORKERS', response.data );
            })
        }
    }
}
</script>
<style scoped>
.graphics-card{
    border: 1px solid #cccc;
    border-radius: 4px;
    padding-bottom: 15px;
    box-shadow: 0 2px 5px 1px rgb(64 60 67 / 16%);
}
.list-card{
    border: 1px solid #cccc;
    border-radius: 4px;
    padding-bottom: 15px;
    box-shadow: 0 2px 5px 1px rgb(64 60 67 / 16%);
    margin-left: 50px;
    overflow-y:auto;
    height: 550px;
}
@media (max-width: 991px){
    .list-card{
        margin-top: 20px;
        margin-left: 0px;
    }
}
.container-card {
    margin-top:20px;
    left:0;
    right:0;
    margin-left: auto;
    margin-right: auto;
    width:98%;
}
</style>
