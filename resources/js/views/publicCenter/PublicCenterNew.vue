<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.public_centers.public_center')}}</h3>
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
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.public_centers.public_centers'),
              to: { name: 'public_center' }
          },
          {
              text: trans.translate('general.add'),
              active: true
          }
      ],
      formIn: {
        formFrom:trans.translate('general.public_centers.public_centers'),
        label: trans.translate('general.name'),
        placeholder: trans.translate('general.name'),
        action: trans.translate('general.save'),
        form: {
            name: ''
        },
        uri:'admin/public_center',
        method: 'POST',
        route:'/public_center'
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
