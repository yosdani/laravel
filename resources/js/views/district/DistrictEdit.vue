<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Distrito</h3>
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
              text: 'Distrito',
              to: { name: 'district' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Distrito',
        label: 'Entre el nuevo distrito',
        placeholder: 'Entre el nuevo distrito',
        action: 'Editar',
        form: {
            name: ''
        },
        uri:'admin/district',
        method: 'PUT',
        route:'/district'
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
          axios.get('/admin/district/'+id)
          .then(response => {
              this.formIn.form.name = response.data.district.district;
              this.formIn.uri = this.formIn.uri+'/'+response.data.district.id;
          })
      }
  }
}
</script>

<style scoped>

</style>