<template>
    <div class="card-dashboard row" :style="putOfMarginNegative">
            <statistics class="col-lg-3 col-md-6 col-sm-12 border-stadistics" :color="'green'" :iconName="'wallet2'" :name="translate('general.dashboard_statistics.total_incidences')" :number="datas.total"/>
            <statistics class="col-lg-3 col-md-6 col-sm-12 border-stadistics three-component" :color="'orange'" :iconName="'calendar2-check-fill'" :name="translate('general.dashboard_statistics.finished')" :number="datas.finished"/>
            <statistics class="col-lg-3 col-md-6 col-sm-12 border-stadistics" :color="'blue'" :iconName="'bar-chart-steps'" :name="translate('general.dashboard_statistics.in_progress')" :number="datas.inProgress"/>
            <statistics class="col-lg-3 col-md-6 col-sm-12" :color="'red'" :iconName="'exclamation-triangle-fill'" :name="translate('general.dashboard_statistics.not_assigned')" :number="datas.notAssigned"/>
    </div>
</template>
<script>
import Statistics from './statistics'
import EventBus from '../../../../components/event-bus';
import trans from '../../../../VueTranslation/Translation'
export default {
    props:["datas"],
    components:{
        Statistics
    },
    computed:{
        putOfMarginNegative(){
            return {
                left: 0,
                right: 0,
                margin:'auto'
            }
        }
    }
}
</script>
<style scoped>
.card-dashboard {
    width: 98%;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid #cccc;
    box-shadow: 0 2px 5px 1px rgb(64 60 67 / 16%);
}

.border-statistics{
    border-right: 1px solid #cccc;
}
@media (max-width:991px){
    .three-component{
        border-right: none;
    }
}
@media (max-width:767px){
    .border-stadistics{
        border-right: none;
    }
}
</style>
