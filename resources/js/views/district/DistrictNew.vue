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
              text: 'Distrito',
              to: { name: 'district' }
          },
          {
              text: 'Adicionar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Estados',
        label: 'Entre el distrito',
        placeholder: 'Entre el distrito',
        action: 'Adicionar',
        form: {
            name: ''
        },
        uri:'admin/district',
        method: 'POST',
        route:'/district'
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