<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.streets.street')}}</h3>
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
              text: trans.translate('general.streets.streets'),
              to: { name: 'street' }
          },
          {
              text: trans.translate('general.add'),
              active: true
          }
      ],
      formIn: {
          formFrom:trans.translate('general.streets.street'),
          label: trans.translate('general.streets.name'),
          placeholder: trans.translate('general.streets.name'),
          action: trans.translate('general.save'),
          actionMessage: trans.translate('general.created') + trans.translate('general.art_female'),
          form: {
              street: '',
              number: ''
          },
          uri:'admin/street',
          method: 'POST',
          route:'/street'
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
