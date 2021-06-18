<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Centro Público</h3>
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
              text: 'Centros Públicos',
              to: { name: 'public_center' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Centros Públicos',
        label: 'Centros Públicos',
        placeholder: 'Entre el Centros Públicos',
        action: 'Editar',
        form: {
            name: ''
        },
        uri:'admin/public_center',
        method: 'PUT',
        route:'/public_center'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getPublicCenterById( this.$route.params.id );
  },
  methods:{
      getPublicCenterById(id) {
          axios.get('/admin/public_center/'+id)
          .then(response => {
              this.formIn.form.name = response.data.public_center.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.public_center.id;
          })
      }
  }
}
</script>

<style scoped>

</style>