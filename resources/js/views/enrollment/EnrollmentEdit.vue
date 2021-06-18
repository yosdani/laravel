<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.enrolments.enrolment')}}</h3>
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
              text: trans.translate('general.enrolments.enrolments'),
              to: { name: 'enrollment' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom:trans.translate('general.enrolments.enrolment'),
        label: trans.translate('general.enrolments.enrolment'),
        placeholder: trans.translate('general.enrolments.enrolment'),
        action: trans.translate('general.save'),
          actionMessage: trans.translate('general.edited') + trans.translate('general.art_female'),
        form: {
            name: ''
        },
        uri:'admin/enrollment',
        method: 'PUT',
        route:'/enrollment'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getEnrollmentById( this.$route.params.id );
  },
  methods:{
      getEnrollmentById(id) {
          axios.get('/admin/enrollment/'+id)
          .then(response => {
              this.formIn.form.name = response.data.enrollment.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.enrollment.id;
          })
      }
  }
}
</script>

<style scoped>

</style>
