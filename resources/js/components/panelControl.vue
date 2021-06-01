<template>
    <div>
        <!--<button class="button-side-bar" @click="showSideBar">
            <div class="button-side-bar__text">Panel Control</div>
        </button>-->
        <SideBar :elements="listOfData" @getDatas="getElementForData($event)"/>
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
            {name: "News",child:[ 'ADD','Show List']},
            {name: "Categories",child:['ADD','Show List']},
            {name: "State",child:[ 'ADD','Show List']},
            {name: "Areas",child:[ 'ADD','Show List']},
            {name: "Matriculas",child:[ 'ADD','Show List']},
            {name: "Incidens",child:[ 'ADD','Show List']},
            {name: "Rols",child:[ 'ADD','Show List']},
            {name: "Users",child:[ 'ADD','Show List']}
        );
    },
    components:{
        SideBar,
        TableData
    },
    methods:{
        showSideBar(){
            this.show = !this.show;
        },
        getElementForData(event){
            
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
.container{
    width: 70%;
    float: right;
}
</style>