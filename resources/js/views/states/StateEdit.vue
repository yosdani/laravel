<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.states.state')</h3>
            </b-card-header>
            <b-card-body>
                <form-simple :formOut="formIn"></form-simple>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormSimple from '../../components/form/formSimple.vue';
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
              text: trans.translate('general.states.states'),
              to: { name: 'states' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom:trans.translate('general.states.states'),
        label: trans.translate('general.states.state'),
        placeholder: trans.translate('general.states.state'),
        action: trans.translate('general.save'),
        form: {
            name: ''
        },
        uri:'admin/states',
        method: 'PUT',
        route:'/states'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getStateById( this.$route.params.id );
  },
  methods:{
      getStateById(id) {
          axios.get('/admin/states/'+id)
          .then(response => {
              this.formIn.form.name = response.data.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.id;
          })
      }
  }
}
</script>

<style scoped>

</style>
