<template>
    <b-sidebar :visible="show" id="sidebar-1" title="Panel Control" shadow>
      <div class="px-3 py-2">
        <div class="element-sidebar" v-for="(element,i) in elements" :key="i">
            <div v-b-toggle="'collapse' + i" class="m-1 nav-title-sidebar">{{element.name}}</div>
            <b-collapse v-for="(subelement, index) in element.child" :key="index" class="nav-body-sidebar" visible :id="'collapse'+i">
                <div>{{ subelement }}</div>
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
            }
        }
    }
</script>
<style scoped>
.nav-title-sidebar{
    font-size: 1.2rem;
    font-weight: bold;
}
.nav-body-sidebar{
    margin-left: 25px;
}
.element-sidebar{
    margin-left: 15px;
    border-top: 1px solid #cccc;
}
</style>