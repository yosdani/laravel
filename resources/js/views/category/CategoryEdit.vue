<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Categoria</h3>
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
              text: 'Categoria',
              to: { name: 'categories' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Categoria',
        label: 'Entre la nueva categoria',
        placeholder: 'Entre la categoria',
        action: 'Editar',
        form: {
            name: ''
        },
        uri:'admin/category',
        method: 'PUT',
        route:'/categories'
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
          axios.get('/admin/category/'+id)
          .then(response => {
              this.formIn.form.name = response.data.category.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.category.id;
          })
      }
  }
}
</script>

<style scoped>

</style>