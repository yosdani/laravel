<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.roles.role')}}</h3>
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
              text: trans.translate('general.roles.roles'),
              to: { name: 'roles' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom: trans.translate('general.roles.roles'),
        label: trans.translate('general.roles.role'),
        placeholder: trans.translate('general.roles.role'),
        action: trans.translate('general.save'),
        form: {
            name: ''
        },
        uri:'admin/roles',
        method: 'PUT',
        route:'/roles'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getRolById( this.$route.params.id );
  },
  methods:{
      getRolById(id) {
          axios.get('/admin/roles/'+id)
          .then(response => {
              this.formIn.form.name = response.data.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.id;
          })
      }
  }
}
</script>

<style scoped>

</style>
