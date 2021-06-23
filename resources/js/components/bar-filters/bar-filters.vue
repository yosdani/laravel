<template>
    <div>
        <div class="card-dashboard row" :style="putOfMarginNegative">
            <div class="dropdown col-lg-5 label-filters">
                <b-icon class="label-filters-calendar col-lg-2 "  icon="calendar2-week-fill"></b-icon>
                <period-filter
                    :range="filters?filters.period:'year'"
                    @timer="getTimer($event)"
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
                    :tags="states"
                    :placeholder="'Filter by state'"
                    :type="'states'"
                    :values="value_states"
                    @addStates="getValuesStates($event)"
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
                    :type="'tags'"
                    :values="value_tags"
                    @addTags="getValuesTags($event)"
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
    props: ['filters'],
    components:{
        TagsFilter,
        periodFilter,
        dropDown,
        giveTime,
    },
    data(){
        return {
            tags:[],
            states:[],
            rangeTime:false,
            value_tags:[],
            value_states:[]
        }
    },
    created() {
        this.getTags();
        this.getStates();
    },
    methods:{
        getTimer(event){
            if(event === 'period'){
                this.rangeTime = true;
            }else{
                this.rangeTime = false;
            }
            this.$emit('sendTimer', event);
        },
        giveNewDates(event){
            EventBus.$emit('GET_TIMER_PERIOD', event);
        },
        getTags(){
            axios.get(window.origin+'/admin/all/tags')
            .then(response=>{
                this.tags = [];
                response.data.tags.map(tag=>{
                    if(this.filters != null)
                        this.filters.tags.map(t=>{
                            if(t == tag.id){
                                this.value_tags.push({
                                    id: t,
                                    name: tag.name
                                })
                            }
                        })
                    this.tags.push({
                        id: tag.id,
                        name: tag.name
                    })
                })
            })
            .catch(error=>{
                this.$swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: error,
              })
            })
        },
        getStates(){
            axios.get(window.origin+'/admin/all/states')
            .then(response=>{
                this.states = []; 
                response.data.states.map(states=>{
                    if(this.filters != null)
                        this.filters.states.map(s=>{
                            if(s == states.id){
                                this.value_states.push({
                                    id: s,
                                    name: states.name
                                })
                            }
                        })
                    this.states.push({
                        id: states.id,
                        name: states.name
                    })
                })
            })
            .catch(error=>{
                this.$swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: error,
              })
            })
        }
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
