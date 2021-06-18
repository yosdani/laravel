<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.users.user')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-object :formOut="formIn"></form-object>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormObject from "../../components/form/FormObject.vue";
import trans from '../../VueTranslation/Translation';
export default {
    data() {
    return {
      bItems: [
          {
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.users.users'),
              to: { name: 'users' }
          },
          {
              text: trans.translate('general.add'),
              active: true
          }
      ],
      formIn: {
        formFrom:'User',
        action: trans.translate('general.add'),
        form: {
            email: '',
            name: '',
            lastName: '',
            phoneNumber: '',
            password: '',
            role:''
        },
        roles:[],
        uri:'admin/users',
        method: 'POST'
      }
    };
  },
  components:{
      FormObject
  },
  mounted() {
     this.getRoles();
  },
  methods: {
      getRoles(){
          fetch(window.origin+'/admin/roles')
            .then((response) => response.json())
            .then((response) => {
                response.map(r=>{
                    this.formIn.roles.push({
                        text: r.name,
                        value: r.name
                    })
                })
            });
      }
    }
}
</script>

<style scoped>

</style>
