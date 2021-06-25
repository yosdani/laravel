<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.priorities.priority')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-simple :formOut="formIn"></form-simple>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormSimple from '../../components/form/formSimple.vue';
import trans from '../../VueTranslation/Translation';
export default {
    data() {
    return {
      bItems: [
          {
              text: trans.translate('general.dashboard'),
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.priorities.priorities'),
              to: { name: 'priority' }
          },
          {
              text: trans.translate('general.add'),
              active: true
          }
      ],
      formIn: {
          formFrom:trans.translate('general.priorities.prioriy'),
          label: trans.translate('general.name'),
          placeholder: trans.translate('general.name'),
          action: trans.translate('general.save'),
          actionMessage: trans.translate('general.created') + trans.translate('general.art_male'),
          form: {
              name: ''
          },
          uri:'admin/priority',
          method: 'POST',
          route:'/priority'
      }
    };
  },
  components:{
    FormSimple
  }
}
</script>

<style scoped>

</style>
