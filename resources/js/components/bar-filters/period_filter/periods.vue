<template>
  <div class="item-drop" @click="rangeSelected">{{ range }}</div>
</template>
<script>
import EventBus from '../../event-bus';
export default {
  name: 'periods',
  props: ['range'],
  methods: {
    rangeSelected() {
      EventBus.$emit('RANGE_SELECTED', this.range);
    }
  }
};
</script>
<style scoped>
.item-drop {
  padding: 10px 20px;
  font-weight: 600;
  cursor: pointer;
}
</style>