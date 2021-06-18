<template>
    <date-range-picker
        ref="picker"
        :opens="'center'"
        :startDate="dateRange.startDate"
        :endDate="dateRange.endDate"
        @update="valuesRange"
        v-model="dateRange"
        :locale-data="locale"
        :ranges="false"
        :showDropdowns="true"
        :linked-calendars="false"
    >
    <!--Optional scope for the input displaying the dates -->
      <div slot="input" >{{dateRange.startDate +' - '+ dateRange.endDate}}</div>
    </date-range-picker>
</template>
<script>
import DateRangePicker from 'vue2-daterange-picker'
export default {
  name: 'give-time',
  props: ["lang","dateInit","dateEnd"],
  data(){
    return {
      dateRange:{
        startDate: null,
        endDate: null,
      },
      localeEn: {
          direction: 'ltr', //direction of text
          format: 'DD-MM-YYYY', //fomart of the dates displayed
          separator: ' - ', //separator between the two ranges
          applyLabel: trans.translate('general.apply'),
          cancelLabel: trans.translate('general.cancel'),
          weekLabel: 'W',
          customRangeLabel: trans.translate('general.period'),
          daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
          monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          firstDay: 1 //ISO first day of week - see moment documenations for details
      },
      localeEs : {
          direction: 'ltr', //direction of text
          format: 'DD-MM-YYYY', //fomart of the dates displayed
          separator: ' - ', //separator between the two ranges
          applyLabel: trans.translate('general.apply'),
          cancelLabel: trans.translate('general.cancel'),
          weekLabel: 'W',
          customRangeLabel: trans.translate('general.graph.period'),
          daysOfWeek: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
          monthNames: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
          firstDay: 1 //ISO first day of week - see moment documenations for details
      }
    }
  },
  created() {
    if(this.dateInit == null) {
      this.dateRange.startDate = new Date().toLocaleDateString();
    }else{
      this.dateRange.startDate = this.dateInit;
    }
    if(this.dateEnd == null) {
      this.dateRange.endDate = new Date().toLocaleDateString();
    }else{
      this.dateRange.endDate = this.dateEnd;
    }
  },
  components: {
    DateRangePicker
  },
  methods: {
    valuesRange(value){
      this.dateRange.endDate = value.endDate.toLocaleDateString();
      this.dateRange.startDate = value.startDate.toLocaleDateString();
      this.$emit('changedaterange',[this.dateRange.startDate, this.dateRange.endDate]);
    }
  },
  computed:{
    locale(){
      if(this.lang === 'en')
        return this.localeEn
        else
        return this.localeEs;
    }
  }
};
</script>
<style src="vue2-daterange-picker/dist/vue2-daterange-picker.css"></style>

