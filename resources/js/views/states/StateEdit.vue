<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Estado</h3>
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
              text: 'Estados',
              to: { name: 'states' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Estados',
        label: 'Entre el nuevo tipo de estado',
        placeholder: 'Entre el nuevo estado',
        action: 'Editar',
        form: {
            name: ''
        },
        uri:'admin/states',
        method: 'PUT',
        route:'/states'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getStateById( this.$route.params.id );
  },
  methods:{
      getStateById(id) {
          axios.get('/admin/states/'+id)
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