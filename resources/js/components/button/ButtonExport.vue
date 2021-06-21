<template>
    <export-excel class= "btn btn-primary text-right" :data="options">
        Download Data
    </export-excel>
</template>

<script>
import excel from 'vue-excel-export';
export default {
    props: ["options"],
    components:{
        'export-excel': excel
    },
    methods:{
        executeAction(){
            alert('click to export');
        }
    }
}
</script>