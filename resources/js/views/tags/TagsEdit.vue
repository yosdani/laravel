<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Etiqueta</h3>
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
              text: 'Etiquetas',
              to: { name: 'tags' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Etiquetas',
        label: 'Etiqueta',
        placeholder: 'Entre la etiqueta',
        action: 'Editar',
        form: {
            name: ''
        },
        uri:'admin/tags',
        method: 'PUT',
        route:'/tags'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getTagById( this.$route.params.id );
  },
  methods:{
      getTagById(id) {
          axios.get('/admin/tags/'+id)
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