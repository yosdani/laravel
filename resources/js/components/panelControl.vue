<template>
    <div>
        <!--<button class="button-side-bar" @click="showSideBar">
            <div class="button-side-bar__text">Panel Control</div>
        </button>-->
        <SideBar :elements="listOfData" @getDatas="getElementForData($event)"/>
        <div class="container">
            <b-card>
                <TableData 
                    :items="listDataShow" 
                    :fields="fields"
                />
            </b-card>
        </div>
    </div>
    
</template>
<script>
import SideBar from "./sideBar/sideBar";
import TableData from "./table/tableData";
export default {
    props:['user'],
    data(){
        return {
            show:false,
            listOfData : [],
            uri:window.origin,
            listDataShow : [],
            fields: []
        }
    },
    created(){
        console.log(this.user);
        this.listOfData.push(
            {name: "News",child:[ 'ADD','Show List']},
            {name: "Categories",child:['ADD','Show List']},
            {name: "State",child:[ 'ADD','Show List']},
            {name: "Areas",child:[ 'ADD','Show List']},
            {name: "Matriculas",child:[ 'ADD','Show List']},
            {name: "Incidens",child:[ 'ADD','Show List']},
            {name: "Roles",child:[ 'ADD','Show List']},
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
            switch(event['name']){
                case "Users":this.getUsersDatas();
                break;
                case "Roles":this.getRolesDatas();
                break;
                case "Matriculas":this.getMatriculasDatas();
                break;
                case "Categories":this.getCategoriesDatas();
                break;
            }
            
        },
        getUsersDatas(){
            fetch(this.uri+'/users')
                .then(response => response.json())
                .then(response=>{
                    this.listDataShow = response.users;
                    this.fields = [
                        { key: 'name', label: 'Name', sortable: true, sortDirection: 'desc' },
                        { key: 'lastName', label: 'Last Name', sortable: true, class: 'text-center' },
                        { key: 'email', label: 'Email', sortable: true, sortDirection: 'desc' },
                        { key: 'phoneNumber', label: 'Phone Number', sortable: true, class: 'text-center' },
                    ]
                })
        },
        getRolesDatas(){
            fetch(this.uri+'/api/v1/roles')
                .then(response => response.json())
                .then(response=>{
                    this.listDataShow = response.users;
                    this.fields = [
                        { key: 'name', label: 'Name', sortable: true, sortDirection: 'desc' },
                    ]
                })
        },
        getMatriculasDatas(){
            fetch(this.uri+'/matriculas')
                .then(response => response.json())
                .then(response=>{
                    this.listDataShow = response.matriculas;
                    this.fields = [
                        { key: 'name', label: 'Name', sortable: true, sortDirection: 'desc' },
                    ]
                })
        },
        getCategoriesDatas(){
            fetch(this.uri+'/category')
                .then(response => response.json())
                .then(response=>{
                    this.listDataShow = response.category;
                    this.fields = [
                        { key: 'name', label: 'Name', sortable: true, sortDirection: 'desc' },
                    ]
                })
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
    left: 0;
    right: 0;
    position: absolute;
}
</style>