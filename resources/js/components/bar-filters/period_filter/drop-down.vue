<template>
  <div
    aria-labelledby="dropdownMenu2"
    class="dropdown-menu dropdown-menu-checkbox"
  >
    <periods :range="'Hoy'" />
    <periods :range="'Ultima semana'" />
    <periods :range="'Ultimo mes'" />
    <periods :range="'Ultimo año'" />
    <periods :range="'Periodo definido'" />
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