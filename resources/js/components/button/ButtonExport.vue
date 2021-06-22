<template>
    <download-excel
        class="btn btn-primary"
        :data="json_data"
        name="incidences.xls"
    >
       {{ translate('general.incidences.export')}}
    </download-excel>
</template>

<script>
import JsonExcel from "vue-json-excel";
import trans from "../../VueTranslation/Translation";
export default {
    props: ["options"],
    components:{
        'downloadExcel': JsonExcel
    },
    methods:{
        executeAction(){
            alert('click to export');
        }
    }
}
</script>