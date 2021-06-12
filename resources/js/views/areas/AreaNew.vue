<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Adicionar Area</h3>
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
              text: 'Areas',
              to: { name: 'areas' }
          },
          {
              text: 'Adicionar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Areas',
        label: 'Entre el area',
        placeholder: 'Entre el area',
        action: 'Adicionar',
        form: {
            name: '',
            user_id: ''
        },
        array:[],
        uri:'admin/areas',
        method: 'POST',
        route:'/areas'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getResponsables();
  },
  methods:{
      getResponsables(){
          axios.get(window.origin+'/admin/responsables/areas')
          .then(response =>{
            response.data.responsables.map(r=>{
                this.formIn.array.push({
                    text: r.email,
                    value: r.id
                })
            })
          })
      }
  }
}
</script>

<style scoped>

</style>