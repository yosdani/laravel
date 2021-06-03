<template>
    <b-sidebar 
        :visible="true" 
        id="sidebar1" 
        title="Dashboard" 
        bg-variant="dark" 
        text-variant="light" 
        shadow 
        :style="customSidebar"
    >
      <div class="px-3 py-2">
        <div class="element-sidebar" v-for="(element,i) in elements" :key="i">
            <div @click="rotateIcon(i)" v-b-toggle="'collapse' + i" class="m-1 nav-title-sidebar">{{element.name}}<b-icon icon="text-right" class="float-right" :id="'icon-sidebar-'+i" aria-hidden="true"></b-icon></div>
            <b-collapse v-for="(subelement, index) in element.child" :key="index" class="nav-body-sidebar" hide :id="'collapse'+i">
                <div @click="getDatas(element)" style="cursor:pointer;">{{ subelement }}</div>
            </b-collapse>
        </div>
      </div>
    </b-sidebar>
</template>
<script>
    export default {
        name: "SideBar",
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
            rotateIcon(index){
                this.rotate = !this.rotate;
                if(this.rotate)
                    document.getElementById("icon-sidebar-"+index).classList.add("rotate-icon");
                    else
                    document.getElementById("icon-sidebar-"+index).classList.remove("rotate-icon");
            },
            getDatas(element){
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
    font-size: 1.2rem;
    font-weight: bold;
    display: inline;
}
.nav-body-sidebar{
    margin-left: 40px;
    font-size: 15px;
}
.element-sidebar{
    margin-left: 15px;
    margin-bottom: 15px;
}
.sidebar-dashboard{
    top: 58px;
    width: 200px;
    max-height: 100%;
}
.rotate-icon{
    transform: rotate(90deg);
}
</style>