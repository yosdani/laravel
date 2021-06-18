<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.districts.district')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-simple :formOut="formIn"></form-simple>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormSimple from '../../components/form/formSimple.vue';
import trans from "../../VueTranslation/Translation";
export default {
    data() {
    return {
      bItems: [
          {
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.districts.districts'),
              to: { name: 'district' }
          },
          {
              text: trans.translate('general.add'),
              active: true
          }
      ],
      formIn: {
        formFrom:trans.translate('general.districts.districts'),
        label: trans.translate('general.districts.districts'),
        placeholder: trans.translate('general.districts.districts'),
        action: trans.translate('general.save'),
        form: {
            name: ''
        },
        uri:'admin/district',
        method: 'POST',
        route:'/district'
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
