<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Adicionar Estado</h3>
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
              text: 'Estados',
              to: { name: 'states' }
          },
          {
              text: 'Adicionar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Estados',
        label: 'Entre el tipo de estado',
        placeholder: 'Entre el estado',
        action: 'Adicionar',
        form: {
            name: ''
        },
        uri:'admin/states',
        method: 'POST'
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