<template>
  <div class="graphic-dashboard">
    <canvas id="idBarGraph"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';
import EventBus from '../../../../components/event-bus';
import {mapState} from "vuex";
export default {
  data(){
    return {
      myChart : null
    }
  },
  mounted() {
    EventBus.$on('GET_DATAS_BAR', payload => {
      let ctx = document.getElementById('idBarGraph').getContext("2d");
      
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
