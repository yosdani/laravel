<template>
  <span
    type="button"
    data-toggle="dropdown"
    aria-haspopup="true"
    aria-expanded="false"
    class="filtro-item filtro-active filter-time dropdown-toggle"
  >
    <span class="text-filter-time">{{ type }}</span>
  </span>
</template>
<script>
import giveTime from './give-time';
import EventBus from '../../event-bus';
export default {
  name: 'period-filter',
  props: ['range', 'language' ],
  data() {
    return {
      type: ''
    };
  },
  components: {
    giveTime
  },
  created() {
      this.range === 'year'?this.type= 'Ultimo año':
      this.range === 'month'?this.type= 'Ultimo mes':
      this.range === 'week'?this.type= 'Ultima semana':
      this.range === 'day'?this.type= 'Hoy':
      this.type = 'Periodo definido'
  },
  mounted() {
    EventBus.$on('RANGE_SELECTED', (payload) => {
      this.getDate(payload)
      this.type = payload
    });
  },
  methods: {
    getDate(time){
      switch(time){
        case 'Ultimo año':EventBus.$emit('TIMER','year');break;
        case 'Ultimo mes':EventBus.$emit('TIMER','month');break;
        case 'Ultima semana':EventBus.$emit('TIMER','week');break;
        case 'Hoy':EventBus.$emit('TIMER','day');break;
        case 'Periodo definido':EventBus.$emit('TIMER','period');break;
      }
    }
  }
};
</script>
<style scoped>
.caret {
  display: inline-block;
  width: 0;
  height: 0;
  margin-left: 2px;
  vertical-align: middle;
  border-top: 4px dashed;
  border-top: 4px solid\9;
  border-right: 4px solid transparent;
  border-left: 4px solid transparent;
}
.text-filter-time{
  font-style: italic;
}
</style>