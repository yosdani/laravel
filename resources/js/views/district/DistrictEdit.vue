<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.districts.district')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-simple :formOut="formIn"></form-simple>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormSimple from '../../components/form/formSimple.vue';
import trans from "../../VueTranslation/Translation";
export default {
    data() {
    return {
      bItems: [
          {
              text: trans.translate('general.dashboard'),
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.districts.districts'),
              to: { name: 'district' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom:trans.translate('general.districts.district'),
        label: trans.translate('general.districts.district'),
        placeholder: trans.translate('general.districts.district'),
        action: trans.translate('general.save'),
          actionMessage: trans.translate('general.edited') + trans.translate('general.art_male'),
        form: {
            name: ''
        },
        uri:'admin/district',
        method: 'PUT',
        route:'/district'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getById( this.$route.params.id );
  },
  methods:{
      getById(id) {
          axios.get('/admin/district/'+id)
          .then(response => {
              this.formIn.form.name = response.data.district.district;
              this.formIn.uri = this.formIn.uri+'/'+response.data.district.id;
          })
      }
  }
}
</script>

<style scoped>

</style>
