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
          axios.get(window.origin+'/admin/roles')
            .then((response) => {
                this.formIn.roles = response.data;
            });
      }
    }
}
</script>

<style scoped>

</style>
