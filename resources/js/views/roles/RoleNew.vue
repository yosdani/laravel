<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Adicionar Rol</h3>
            </b-card-header>
            <b-card-body>
                <form-object :formOut="formIn"></form-object>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormObject from "../../components/form/FormObject.vue"
export default {
    data() {
        return {
            bItems: [
                {
                    text: 'Dashboard',
                    to: { name: 'dashboard' }
                },
                {
                    text: 'Roles',
                    to: { name: 'roles' }
                },
                {
                    text: 'Adicionar',
                    active: true
                }
            ],
            formIn: {
                formFrom:'Roles',
                form: {
                    name: ''
                },
                action: 'Guardar',
                uri:'admin/roles',
                method: 'POST',
                route:'/states'
            }
        };
  },
  components:{
      FormObject
  }
}
</script>

<style scoped>

</style>
