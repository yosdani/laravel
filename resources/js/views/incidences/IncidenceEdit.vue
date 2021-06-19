<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.incidences.incidence')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-incidence :formOut="formIn"></form-incidence>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormIncidence from "../../components/form/FormIncidence.vue";
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
              text: trans.translate('general.incidences.incidences'),
              to: { name: 'incidences' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
          formFrom: trans.translate('general.incidences.incidence'),
          action: trans.translate('general.save'),
          actionMessage: trans.translate('general.edited') + trans.translate('general.art_female'),
          form: {
              address: '',
              applicant: '',
              assigned_id: '',
              attachedContent: '',
              breakdown_id: '',
              enrolment_id: '',
              deadline: '',
              description: '',
              district_id: '',
              title: '',
              neighborhood_id:'',
              public_center_id: '',
              responseForCitizen: '',
              state_id: '',
              street_id: '',
              tags: '',
              team: '',
              user_id: '',
              area_id: '',
        },
        roles:[],
        workers:[],
        enrollments:[],
        states:[],
        uri:'admin/incidences',
        method: 'PUT',
        route:'/incidences'
      }
    };
  },
  components:{
      FormIncidence
  },
  mounted() {
     //this.getRoles();
    this.getIncidenceById( this.$route.params.id );
    this.getWorkers();
    this.getEnrollment();
    this.getStates();
  },
  methods: {
      getRoles(){
          fetch( window.origin+'/admin/roles')
            .then((response) => response.json())
            .then((response) => {
                response.map(r=>{
                    this.formIn.roles.push({
                        text: r.name,
                        value: r.name
                    })
                })
            });
      },
      getIncidenceById(id) {
          axios.get(window.origin+'/admin/incidences/'+id)
          .then(response=>{
            this.formIn.form = response.data;
            this.formIn.form._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            this.formIn.uri = this.formIn.uri+'/'+response.data.id;
          })
      },
      getWorkers(){
          axios.get(window.origin+'/admin/workers')
          .then(response=>{
              response.data.workers.map(worker=>{
                  this.formIn.workers.push({
                      value: worker.id,
                      text: worker.email
                  });
              })
          })
      },
      getEnrollment(){
          axios.get(window.origin+'/admin/enrollment')
          .then(response => {
              response.data.enrollment.data.map(enrollment => {
                  this.formIn.enrollments.push({
                      value: enrollment.id,
                      text: enrollment.name
                  })
              })
          })
      },
      getStates(){
          axios.get(window.origin+'/admin/states')
          .then(response => {
              response.data.states.data.map(state => {
                  this.formIn.states.push({
                      value: state.id,
                      text: state.name
                  })
              })
          })
      }
    }
}
</script>

<style scoped>

</style>
