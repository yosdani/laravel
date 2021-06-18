<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Adicionar Etiqueta</h3>
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
              text: 'Adicionar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Etiquetas',
        label: 'Etiqueta',
        placeholder: 'Entre la etiqueta',
        action: 'Adicionar',
        form: {
            name: ''
        },
        uri:'admin/tags',
        method: 'POST',
        route:'/tags'
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