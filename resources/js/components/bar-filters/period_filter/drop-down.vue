<template>
  <div
    aria-labelledby="dropdownMenu2"
    class="dropdown-menu dropdown-menu-checkbox"
  >
    <periods :range="translate('general.graph.today')" />
    <periods :range="translate('general.graph.last_week')" />
    <periods :range="translate('general.graph.last_month')" />
    <periods :range="translate('general.graph.last_year')" />
    <periods :range="translate('general.graph.period')" />
  </div>
</template>
<script>
import periods from './periods';
export default {
  name: 'drop-down',
  props: [ 'language' ],
  components: {
    periods
  }
};
</script>
<style scoped>
</style>
