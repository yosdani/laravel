<template>
    <div style="margin-top:40px;margin-left:160px;">
        <SideBar :elements="listOfData" @getDatas="getElementForData($event)"/>
        <div class="dashboard-body">
            <Dashboard 
                v-if="whatsShow=='Dashboard'"
            />
            <Cards
                v-if="whatsShow=='News'"
                :listOfData="listDataShow"
            />
            <b-card v-if="false">
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
import Cards from "./cards/cards"
import Dashboard from "./dashboard/dashboard"
export default {
    props:['user'],
    data(){
        return {
            show:false,
            listOfData : [],
            uri:window.origin,
            listDataShow : [],
            fields: [],
            whatsShow: 'Dashboard'
        }
    },
    created(){
        this.listOfData.push(
            {name: "Dashboard",child: []},
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
        TableData,
        Cards,
        Dashboard
    },
    methods:{
        showSideBar(){
            this.show = !this.show;
        },
        getElementForData(event){
            this.whatsShow = event.name;
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
            fetch(this.uri+'/api/v1/roles',{
                method: 'GET',
                headers: {
                    'content-type': 'application/json',
                    'Authorization' : 'Bearer '+this.user.token_user
                }
            })
                .then(response => response.json())
                .then(response=>{
                    this.listDataShow = response;
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

.dashboard-body{
    
}
</style>