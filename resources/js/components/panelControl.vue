<template>
    <div>
        <button class="button-side-bar" @click="showSideBar">
            <div class="button-side-bar__text">Panel Control</div>
        </button>
        <SideBar :show="show" :elements="listOfData"/>
        <div class="container">
            <b-card>
                <TableData />
            </b-card>
        </div>
    </div>
    
</template>
<script>
import SideBar from "./sideBar/sideBar";
import TableData from "./table/tableData";
export default {
    data(){
        return {
            show:false,
            listOfData : [],
        }
    },
    created(){
        this.listOfData.push(
            {name: "Noticias",child:[ 'Adicionar','Ver Lista']},
            {name: "Categorias",child:['Adicionar','Ver Lista']},
            {name: "Estados",child:[ 'Adicionar','Ver Lista']},
            {name: "Areas",child:[ 'Adicionar','Ver Lista']},
            {name: "Matriculas",child:[ 'Adicionar','Ver Lista']},
            {name: "Incidencias",child:[ 'Adicionar','Ver Lista']},
            {name: "Roles",child:[ 'Adicionar','Ver Lista']},
            {name: "Usuarios",child:[ 'Adicionar','Ver Lista']}
        );
    },
    components:{
        SideBar,
        TableData
    },
    methods:{
        showSideBar(){
            this.show = !this.show;
        }
    },
    computed:{
        giveMarginBottom(){
            return 'margin-bottom:10px';
        }
    }
}
</script>
<style scoped>
.button-side-bar {
    display: block;
    opacity: .96;
    height: 110px;
    position: fixed;
    direction: ltr !important;
    bottom: 40%;
    border: 0;
    width: 30px;
    background: #1aa9df;
    cursor: pointer;
    transition: box-shadow 0.1s ease-in-out;
    z-index: 1024;
    border: 1px solid #FFF;
    outline: none;
    padding: 0;
}
.button-side-bar__text{
    padding: 0.25rem;
    color: #ffffff;
    display: inline-block !important;
    overflow-wrap: normal !important;
    word-break: normal !important;
    word-wrap: normal !important;
    white-space: nowrap !important;
    cursor: pointer;
    filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
    -webkit-writing-mode: vertical-lr;
    -moz-writing-mode: vertical-lr;
    -ms-writing-mode: tb-rl;
    -o-writing-mode: vertical-lr;
    writing-mode: vertical-lr;

}
</style>