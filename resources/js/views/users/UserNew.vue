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
              text: trans.translate('general.dashboard'),
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
        formFrom: trans.translate('general.users.user'),
        action: trans.translate('general.save'),
          actionMessage: trans.translate('general.created') + trans.translate('general.art_male'),
        form: {
            email: '',
            name: '',
            lastname: '',
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
