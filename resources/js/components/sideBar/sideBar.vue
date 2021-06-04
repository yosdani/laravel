<template>
    <b-sidebar 
        :visible="true" 
        id="sidebar1" 
        title="" 
        bg-variant="dark" 
        text-variant="light" 
        shadow 
        :style="customSidebar"
    >
      <div class="px-3 py-2">
        <div class="element-sidebar" v-for="(element,i) in elements" :key="i">
            <div v-b-toggle="'collapse' + i" class="m-1 nav-title-sidebar">{{element.name}}<b-icon v-if="element.name=='Dashboard'?false:true" icon="caret-right-fill" class="float-right icon-sideBar" :id="'icon-sidebar-'+i" aria-hidden="true"></b-icon></div>
            <b-collapse v-for="(subelement, index) in element.child" :key="index" class="nav-body-sidebar" hide :id="'collapse'+i">
                <div @click="getDatas(element)" style="cursor:pointer;">{{ subelement }}</div>
            </b-collapse>
        </div>
      </div>
    </b-sidebar>
</template>
<script>
    export default {
        props:[ "show", "elements" ],
        data(){
            return {
               rotate:false,
            }
        },
        mounted(){
            document.getElementById("sidebar1").children[0].children[1].style.display = "none";
            document.getElementById("sidebar1").classList.add("sidebar-dashboard");
        },
        methods: {
            getDatas(element){
                console.log(element);
               this.$emit('getDatas', element);
            }
        },
        computed:{
            customSidebar() {
                return {
                    position: 'absolute'
                }
            }
        }
    }
</script>
<style>
.nav-title-sidebar{
    font-size: .9rem;
    font-weight: bold;
    display: inline;
}
.nav-body-sidebar{
    margin-left: 15px;
    font-size: 15px;
}
.element-sidebar{
    margin-left: 5px;
    margin-bottom: 15px;
}
.sidebar-dashboard{
    top: 58px;
    width: 150px;
    max-height: 100%;
}
.icon-sideBar{
    width: 10px;
    margin-top: 5px;
}
.icon-sideBar:active{
    transform: rotate(90deg);
}
</style>