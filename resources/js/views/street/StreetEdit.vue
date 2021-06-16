<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Calle</h3>
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
              text: 'Calles',
              to: { name: 'street' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Calles',
        label: 'Calle',
        placeholder: 'Entre la calle',
        action: 'Editar',
        form: {
            street: '',
            number: ''
        },
        uri:'admin/street',
        method: 'PUT',
        route:'/street'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getStreetById( this.$route.params.id );
  },
  methods:{
      getStreetById(id) {
          axios.get('/admin/street/'+id)
          .then(response => {
              this.formIn.form.street = response.data.street.street;
              this.formIn.form.number = response.data.street.number;
              this.formIn.uri = this.formIn.uri+'/'+response.data.street.id;
          })
      }
  }
}
</script>

<style scoped>

</style>