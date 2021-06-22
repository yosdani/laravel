<template>
  <div class="graphic-dashboard">
    <canvas id="idRadarGraph"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';
import EventBus from '../../../../components/event-bus'
export default {
  props: ['data'],
  data(){
    return {
      myChart : null
    }
  },
  mounted() {
      const ctx = document.getElementById('idRadarGraph').getContext("2d");
    
      if (this.myChart) {
          this.myChart.destroy();
      }
      this.myChart = new Chart(ctx, this.data);
  }
}
</script>
<style scoped>
.graphic-dashboard{
  padding-top: 10px;
}
</style>
