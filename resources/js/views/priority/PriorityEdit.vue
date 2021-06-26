<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.priorities.priority')}}</h3>
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
              text: trans.translate('general.dashboard'),
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.priorities.priorities'),
              to: { name: 'priority' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
          formFrom:trans.translate('general.priorities.priority'),
          label: trans.translate('general.name'),
          placeholder: trans.translate('general.name'),
          action: trans.translate('general.save'),
          actionMessage: trans.translate('general.edited') + trans.translate('general.art_male'),
          form: {
              name: ''
          },
          uri:'admin/priority',
          method: 'PUT',
          route:'/priority'
      }
    };
  },
  components:{
      FormSimple
  },
  mounted() {
      this.getPublicCenterById( this.$route.params.id );
  },
  methods:{
      getPublicCenterById(id) {
          axios.get('/admin/priority/'+id)
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
