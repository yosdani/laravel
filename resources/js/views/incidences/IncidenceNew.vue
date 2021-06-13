<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Incidencia</h3>
            </b-card-header>
            <b-card-body>
                <form-incidence :formOut="formIn"></form-incidence>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormIncidence from "../../components/form/FormIncidence.vue"
export default {
    data() {
    return {
      bItems: [
          {
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: 'Incidencias',
              to: { name: 'incidences' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Incidence',
        form: {
            name: '',
            lastName: '',
            phoneNumber: '',
            password: '',
            role:''
        },
        roles:[],
        uri:'admin/users',
        method: 'POST'
      }
    };
  },
  components:{
      FormIncidence
  },
  mounted() {
     this.getRoles();
    this.getIncidenceById( this.$route.id );
  },
  methods: {
      getRoles(){
          fetch( window.origin+'/admin/roles')
            .then((response) => response.json())
            .then((response) => {
                response.map(r=>{
                    this.formIn.roles.push({
                        text: r.name,
                        value: r.name
                    })
                })
            });
      },
      getIncidenceById(id) {
          axios.get(window.origin+'/admin/incidences/'+id)
          then(response=>{
              console.log(response);
          })
      }
    }
}
</script>

<style scoped>

</style>