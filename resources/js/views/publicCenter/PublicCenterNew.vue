<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Adicionar Centro Público</h3>
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
              text: 'Adicionar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Centros Públicos',
        label: 'Centros Públicos',
        placeholder: 'Entre el Centros Públicos',
        action: 'Adicionar',
        form: {
            name: ''
        },
        uri:'admin/public_center',
        method: 'POST',
        route:'/public_center'
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