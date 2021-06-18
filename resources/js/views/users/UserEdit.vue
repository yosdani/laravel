<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.users.user')}}</h3>
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
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom: trans.translate('general.users.user'),
        action: trans.translate('general.save'),
        actionMessage: trans.translate('general.edited') + trans.translate('general.art_male'),
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
        method: 'PUT',
        route: '/users'
      }
    };
  },
  components:{
      FormObject
  },
  mounted() {
     this.getRoles();
     this.getUserById( this.$route.params.id );
  },
  methods: {
      getRoles(){
          fetch(window.origin+'/admin/roles')
            .then((response) => response.json())
            .then((response) => {
                response.map(r=>{
                    this.formIn.roles.push({
                        text: r.name,
                        value: r.id
                    })
                })
            });
      },
      getUserById(id){
          axios.get('/admin/users/'+id)
          .then(response=>{
              this.formIn.form.email = response.data.user.email;
              this.formIn.form.name = response.data.user.name;
              this.formIn.form.lastname = response.data.user.lastname;
              this.formIn.form.phoneNumber = response.data.user.phoneNumber;
              this.formIn.form.password = response.data.user.password;
              this.formIn.form.role = response.data.user.user_role[0].id;
              this.formIn.uri = this.formIn.uri+'/'+response.data.user.id;
          })
      }
    }
}
</script>

<style scoped>

</style>
