<template>
    <div style="margin-top: 20px;">
        <bar-filters />
        <div v-show="show_button_filter" class="row card-dashboard">
            <b-button class="col-lg-12" @click="filterStatistics" :style="giveColor">{{ translate('general.filters.filter') }}</b-button>
        </div>
        <bar-statistics />
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
            loadingBody:true,
            show_button_filter:false
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
        this.getStatistics( this.$store.state.user.filters );
    },
    mounted() {
        EventBus.$on('GET_TIMER_PERIOD', payload =>{
            let filters = this.$store.state.user.filters;
            filters.dateInit = payload[0];
            filters.dateEnd = payload[1];

            this.$store.dispatch('updateFiltersUser', filters);
            this.show_button_filter = true;
        });

        EventBus.$on('UPDATE_FILTERS_tags', payload=>{
            let tags = [];
            payload.map(tag => {
                tags.push(tag.id);
            })
            
            let filters = this.$store.state.user.filters;
            filters.tags = tags; 

            this.$store.dispatch('updateFiltersUser', filters);

            this.show_button_filter = true;
        })

        EventBus.$on('UPDATE_FILTERS_states', payload=>{
            let states = [];
            payload.map(state => {
                states.push(state.id);
            })
            
            let filters = this.$store.state.user.filters;
            filters.states = states; 

            this.$store.dispatch('updateFiltersUser', filters);

            this.show_button_filter = true;
        })

        EventBus.$on('TIMER', payload=>{
            let filters = this.$store.state.user.filters;
            filters.period = payload; 

            this.$store.dispatch('updateFiltersUser', filters);
            this.show_button_filter = true;
        })
    },
    methods: {
        filterStatistics(){
            this.getStatistics( this.$store.state.user.filters );
            this.show_button_filter = false;

        },
        getStatistics( filter_time ){
            axios.put(window.origin + '/admin/dashboard/general',filter_time)
            .then(response => {
                EventBus.$emit('STATISTICS_BAR', [response.data.total,response.data.finished,response.data.in_progress,response.data.not_assigned]);
                EventBus.$emit('GET_DATAS_CARD_WORKERS', response.data.workers );
                EventBus.$emit('GET_DATAS_BAR', {
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
                });

                EventBus.$emit('GET_DATAS_RADAR', {
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
                });
            })
            .catch( error => {
                alert( error.message);
            })

            this.loadingBody = false;
        }
    },
    computed:{
        giveColor(){
            return 'background-color: #6C95C3;';
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
.card-dashboard {
    width: 98%;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid #cccc;
    box-shadow: 0 2px 5px 1px rgb(64 60 67 / 16%);
    left: 0;
    right: 0;
    margin-left:auto;
    margin-right:auto;
}
</style>
