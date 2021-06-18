<template>
    <div style="margin-top: 20px;">
        <bar-filters />
        <bar-statistics />
        <div class="row container-card">
            <div class="graphics-card col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <graphic
                    class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                    :idCanvas="'barGraphic'"
                />
                <graphic-radar
                    class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
                    :idCanvas="'radarGraphic'"
                />
            </div>
            <div class="list-card col-lg-3 col-md-12 col-sm-12 col-xs-12">
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
export default {
    components:{
        Lists,
        Graphic,
        BarStatistics,
        Accordion,
        BarFilters,
        GraphicRadar
    },
    created() {
        this.getDashboardBar();
        this.getDashboardRadar();
        this.getDashboardTeams();
    },
    methods: {
        getDashboardBar(){
            axios.get(window.origin + '/admin/dashboard/bar')
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
                                label: "Finished",
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
        getDashboardRadar(){
            axios.get(window.origin + '/admin/dashboard/radar')
            .then(response => {
                let dataOfGraphicRadar = {
                    type: "radar",
                    data: {
                        labels: response.data.districts,
                        datasets: [
                            {
                                label: trans.translate('general.incidences.by_locality'),
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
        getDashboardTeams(){
            axios.get(window.origin + '/admin/dashboard/teams')
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
