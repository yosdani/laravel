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
      this.range === 'year'?this.type= trans.translate('general.graph.last_year'):
      this.range === 'month'?this.type= trans.translate('general.graph.last_month'):
      this.range === 'week'?this.type= trans.translate('general.graph.last_week'):
      this.range === 'day'?this.type= 'Hoy':
      this.type = trans.translate('general.graph.period')
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
        case trans.translate('general.graph.last_year'):this.$emit('timer','year');break;
        case trans.translate('general.graph.last_month'):this.$emit('timer','month');break;
        case trans.translate('general.graph.last_week'):this.$emit('timer','week');break;
        case trans.translate('general.graph.today'):this.$emit('timer','day');break;
        case trans.translate('general.graph.period'):this.$emit('timer','period');break;
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
