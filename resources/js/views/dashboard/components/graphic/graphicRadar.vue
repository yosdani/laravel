<template>
  <div class="graphic-dashboard">
    <canvas :id="idCanvas"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';
import EventBus from '../../../../components/event-bus'
export default {
  props:["idCanvas"],
  data(){
    return {
      myChart : null
    }
  },
  mounted() {
    EventBus.$on('GET_DATAS_GRAPHIC_RADAR', payload=>{
      const ctx = document.getElementById(this.idCanvas).getContext("2d");
    
      if (this.myChart) {
          this.myChart.destroy();
      }
      this.myChart = new Chart(ctx, payload);
    })
  }
}
</script>
<style scoped>
.graphic-dashboard{
  padding-top: 10px;
}
</style>
