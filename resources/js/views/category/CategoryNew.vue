<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Adicionar Categoria</h3>
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
              text: 'Categorias',
              to: { name: 'categories' }
          },
          {
              text: 'Adicionar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Categoria',
        label: 'Entre la nueva categoria',
        placeholder: 'Entre la categoria',
        action: 'Adicionar',
        form: {
            name: ''
        },
        uri:'admin/category',
        method: 'POST',
        route:'/categories'
      }
    };
  },
  components:{
    FormSimple
  }
}
</script>

<style scoped>

</style>