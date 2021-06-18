<template>
    <div class="card-dashboard row" :style="putOfMarginNegative">
            <statistics class="col-lg-3 col-md-6 col-sm-12 border-statistics" color="green" :iconName="'wallet2'" :name="'Total Incidence'" :number="200"/>
            <statistics class="col-lg-3 col-md-6 col-sm-12 border-statistics three-component" color="orange" :iconName="'calendar2-check-fill'" :name="'Finished'" :number="105"/>
            <statistics class="col-lg-3 col-md-6 col-sm-12 border-statistics" color="blue" :iconName="'bar-chart-steps'" :name="'In Progress'" :number="75"/>
            <statistics class="col-lg-3 col-md-6 col-sm-12" color="red" :iconName="'exclamation-triangle-fill'" :name="'Not Assigned'" :number="20"/>
    </div>
</template>
<script>
import Statistics from './statistics'
export default {
    props:["arrayOfDatas"],
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
