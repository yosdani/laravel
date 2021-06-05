<template>
    <div>
        <div class="card-dashboard row" :style="putOfMarginNegative">
            <div class="dropdown col-lg-5 label-filters">
                <b-icon class="label-filters-calendar col-lg-2 "  icon="calendar2-week-fill"></b-icon>
                <period-filter 
                    :range="'month'"
                />
                <drop-down />
                <give-time
                    v-if="rangeTime" 
                    @changedaterange="giveNewDates($event)"
                />
            </div>
            <div class="col-lg-7 row label-filters">
                <b-icon class="label-filters-category col-lg-2"  icon="archive-fill"></b-icon>
                <TagsFilter    
                    class="col-lg-10"    
                    :tags="categories"
                    :placeholder="'Filter by category'"
                    :type="'CATEGORY'"
                />
            </div>
        </div>
        <div class="card-dashboard" :style="putOfMarginNegative">
            <div class="row label-filters">
                <b-icon class="label-filters-tags col-lg-2"  icon="tags-fill"></b-icon>
                <TagsFilter
                    class="col-lg-10"           
                    :tags="tags"
                    :placeholder="'Filter by tag'"
                    :type="'TAGS'"
                />
            </div>
        </div>
    </div>
</template>
<script>
import TagsFilter from "./tags_filter/tagsFilter"
import periodFilter from "./period_filter/period-filter.vue"
import EventBus from '../event-bus'
import dropDown from "./period_filter/drop-down.vue"
import giveTime from "./period_filter/give-time.vue"
export default {
    name: "BarFilters",
    components:{
        TagsFilter,
        periodFilter,
        dropDown,
        giveTime,
    },
    data(){
        return {
            tags:[
                {id: 1,name: "Aceptado"},
                {id: 2,name: "Rechazado"},
                {id: 3,name: "Repetido"},
                {id: 4,name: "Notificacion Core"},
                {id: 5,name: "Notificacion 72h"},
            ],
            categories:[
                {id: 1,name: "Activas-En Curso"},
                {id: 2,name: "Historico-Finalizadas"}
            ],
            rangeTime:false,
        }
    },
    mounted() {
        EventBus.$on('TIMER',payload=>{
            if(payload === 'period'){
                this.rangeTime = true;
            }else{
                this.rangeTime = false;
                }       
        })
        EventBus.$on( 'RANGE_SELECTED_DETAILS', payload => {
            if( payload === 'Periodo definido'){
                this.details = true;
            }else{
                this.details = false;
            }
        })
        EventBus.$on( 'GET_TAGS', payload=> {
            console.log(payload);
        })
        EventBus.$on('GET_CATEGORY', payload=> {
            console.log(payload);
        })
    },
    methods:{
        giveNewDates(event){
        
        },
    },
    computed:{
        putOfMarginNegative(){
            return {
                left: 0,
                right: 0,
                marginLeft:'auto',
                marginRight:'auto',
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
.border-stadistics{
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
.label-filters{
    top: 0;
    bottom: 0;
    margin: auto;
    color: rgba(0, 0, 0, 0.5);
}
.label-filters-tags{
    fill: rebeccapurple;
    top: 0;
    bottom: 0;
    margin: auto;
}
.label-filters-calendar{
    fill: yellowgreen;
}
.label-filters-category{
    fill: cornflowerblue;
    top: 0;
    bottom: 0;
    margin: auto;
}
</style>