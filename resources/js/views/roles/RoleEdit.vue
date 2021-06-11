<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Rol</h3>
            </b-card-header>
            <b-card-body>
                <form-simple :formOut="formIn"></form-simple>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormSimple from '../../components/form/formSimple.vue';
export default {
    data() {
    return {
      bItems: [
          {
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: 'Roles',
              to: { name: 'roles' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Roles',
        label: 'Entre el nuevo tipo de rol',
        placeholder: 'Entre el nuevo rol',
        action: 'Editar',
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