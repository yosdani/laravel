<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.categories.category')}}</h3>
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
              text: trans.translate('general.categories.category'),
              to: { name: 'categories' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom:trans.translate('general.categories.category'),
        label: trans.translate('general.name'),
        placeholder: '',
        action: trans.translate('general.save'),
        form: {
            name: ''
        },
        uri:'admin/category',
        method: 'PUT',
        route:'/categories'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getById( this.$route.params.id );
  },
  methods:{
      getById(id) {
          axios.get('/admin/category/'+id)
          .then(response => {
              this.formIn.form.name = response.data.category.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.category.id;
          })
      }
  }
}
</script>

<style scoped>

</style>
