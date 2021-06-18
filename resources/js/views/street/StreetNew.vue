<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Adicionar Calle</h3>
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
              text: 'Adicionar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Calles',
        label: 'Calle',
        placeholder: 'Entre la calle',
        action: 'Adicionar',
        form: {
            street: '',
            number: ''
        },
        uri:'admin/street',
        method: 'POST',
        route:'/street'
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