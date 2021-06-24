<template>
    <div>
        <multiselect
            v-model="value"
            :options="tags?tags:''"
            label="name"
            track-by="id"
            :multiple="true"
            :taggable="true"
            :placeholder="placeholder"
            @input="getValues"
            :selectLabel="translate('general.filters.multiselect_label_select')"
            :deselectLabel="translate('general.filters.multiselect_label_remove')"
            :selectedLabel="translate('general.filters.selected')"
        >
            <template #noOptions="">
                <p>{{translate('general.filters.multiselect_list_empty')}}</p>
            </template>
        </multiselect>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import EventBus from '../../event-bus'
import trans from '../../../VueTranslation/Translation';
export default {
    props:["tags","placeholder","type","values"],
    data() {
        return {
            value:[],
            general:[],
            list_empty : '',
        }
    },
    created() {
        this.list_empty = trans.translate('general.filters.multiselect_list_empty');
    },
    beforeMount() {
        this.value = this.values;
    },
    methods:{
        getValues(){
            EventBus.$emit('UPDATE_FILTERS_'+this.type, this.value)
        }
    },
    components:{
        Multiselect
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
