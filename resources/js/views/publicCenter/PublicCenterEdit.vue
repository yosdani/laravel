<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.public_centers.public_center')}}</h3>
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
              text: trans.translate('general.public_centers.public_centers'),
              to: { name: 'public_center' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
          formFrom:trans.translate('general.public_centers.public_center'),
          label: trans.translate('general.name'),
          placeholder: trans.translate('general.name'),
          action: trans.translate('general.save'),
          actionMessage: trans.translate('general.edited') + trans.translate('general.art_male'),
          form: {
              name: ''
          },
          uri:'admin/public_center',
          method: 'PUT',
          route:'/public_center'
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
          axios.get('/admin/public_center/'+id)
          .then(response => {
              this.formIn.form.name = response.data.public_center.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.public_center.id;
          })
      }
  }
}
</script>

<style scoped>

</style>
