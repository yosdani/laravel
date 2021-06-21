<template>
    <div>
        <multiselect
            v-model="value"
            :options="tags?tags:''"
            label="name"
            track-by="id"
            :multiple="true"
            :taggable="true"
            @tag="addTag"
            :placeholder="placeholder"
        ></multiselect>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import EventBus from '../../event-bus'
export default {
    props:["tags","placeholder","type","values"],
    data() {
        return {
            value:[],
        }
    },
    mounted(){
        EventBus.$on('SENT_VALUES_'+this.type, payload=>{
            this.value = payload;
        });
        
    },
    updated(){
        EventBus.$emit('GET_'+this.type, this.value);
    },
    components:{
        Multiselect
    },
    methods:{
        addTag(newTag){
            this.value.push(newTag);
        }
    }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
.popover-categories-filters{
    width: 160px;
}
.popover-categories-filters .popover-body > ul{
    width: 100% !important;
}
.name-categories-filters{
    margin-left: 20px;
    font-size: 20px;
    color: rgba(0, 0, 0, 0.5);
    cursor: pointer;
}
</style>
