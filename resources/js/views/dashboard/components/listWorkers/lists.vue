<template>
    <div>
        <div v-for="(worker,i) in workers" :key="i" class="boss-US" v-b-toggle="'collapse-'+i">{{ worker.response.user?worker.response.user.name: translate('general.card_workers.not_assigned') }}
            <b-badge class="float-right" variant="primary" pill>{{ worker.total }}</b-badge>
            
            <b-collapse :id="'collapse-'+i" class="mt-2">
                <b-list-group>
                    <b-list-group-item v-for="(res,j) in worker.workers" :key="j">{{ res?res.name:'' }}
                        <b-badge class="float-right" variant="primary" pill>{{ res.incidence.length }}</b-badge>
                    </b-list-group-item>
                </b-list-group>
            </b-collapse>
        </div>
    </div>
</template>
<script>
import EventBus from '../../../../components/event-bus';
import trans from '../../../../VueTranslation/Translation'
export default {
    data(){
        return {
            workers : [],
        }
    },
    mounted() {
        EventBus.$on('GET_DATAS_CARD_WORKERS', payload=>{
            this.workers = payload.workers;
        })
    }
}
</script>
<style scoped>
.boss-US{
    font-size: 20px;
    border-bottom: 1px solid #cccc;
    margin-top: 10px;
    padding-bottom: 10px;
    color: rgba(0, 0, 0, 0.5);
}
</style>
