<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Matricula</h3>
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
              text: 'Matricula',
              to: { name: 'enrollment' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Matricula',
        label: 'Entre la nueva matricula',
        placeholder: 'Entre la nueva matricula',
        action: 'Editar',
        form: {
            name: ''
        },
        uri:'admin/enrollment',
        method: 'PUT',
        route:'/enrollment'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getEnrollmentById( this.$route.params.id );
  },
  methods:{
      getEnrollmentById(id) {
          axios.get('/admin/enrollment/'+id)
          .then(response => {
              this.formIn.form.name = response.data.enrollment.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.enrollment.id;
          })
      }
  }
}
</script>

<style scoped>

</style>