<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.categories.category')}}</h3>
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
              text: trans.translate('general.categories.categories'),
              to: { name: 'categories' }
          },
          {
              text: trans.translate('general.add'),
              active: true
          }
      ],
      formIn: {
        formFrom: trans.translate('general.categories.category'),
        label: '',
        placeholder: '',
        action: trans.translate('general.add'),
        form: {
            name: ''
        },
        uri:'admin/category',
        method: 'POST',
        route:'/categories'
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
