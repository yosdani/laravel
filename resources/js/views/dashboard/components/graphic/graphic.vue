<template>
  <div class="graphic-dashboard">
    <canvas :id="idCanvas"></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js';
export default {
  props:["idCanvas","dataOfGraphic"],
  data() {
    return {
      dataGraphic: null
    }
  },
  created(){
      this.dataGraphic = this.dataOfGraphic;
  },
  mounted() {
    const ctx = document.getElementById(this.idCanvas);
    new Chart(ctx, this.dataGraphic);
  }
}
</script>
<style scoped>
.graphic-dashboard{
  padding-top: 10px;
}
</style>
