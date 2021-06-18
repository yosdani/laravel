<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.state.state')}}</h3>
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
              text: trans.translate('general.states.states'),
              to: { name: 'states' }
          },
          {
              text: trans.translate('general.add'),
              active: true
          }
      ],
      formIn: {
        formFrom:trans.translate('general.states.states'),
        label: trans.translate('general.states.state'),
        placeholder: trans.translate('general.states.state'),
        action: trans.translate('general.save'),
          actionMessage: trans.translate('general.created') + trans.translate('general.art_male'),
        form: {
            name: ''
        },
        uri:'admin/states',
        method: 'POST',
        route:'/states'
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
