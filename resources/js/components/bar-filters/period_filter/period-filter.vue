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
  props: ['language' ],
  data() {
    return {
      type: ''
    };
  },
  components: {
    giveTime
  },
  created() {
      this.$store.state.user.filters.period === 'year'?this.type= trans.translate('general.graph.last_year'):
      this.$store.state.user.filters.period === 'month'?this.type= trans.translate('general.graph.last_month'):
      this.$store.state.user.filters.period === 'week'?this.type= trans.translate('general.graph.last_week'):
      this.$store.state.user.filters.period === 'day'?this.type= 'Hoy':
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
        case trans.translate('general.graph.last_year'):EventBus.$emit('TIMER','year');break;
        case trans.translate('general.graph.last_month'):EventBus.$emit('TIMER','month');break;
        case trans.translate('general.graph.last_week'):EventBus.$emit('TIMER','week');break;
        case trans.translate('general.graph.today'):EventBus.$emit('TIMER','day');break;
        case trans.translate('general.graph.period'):EventBus.$emit('TIMER','period');break;
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
