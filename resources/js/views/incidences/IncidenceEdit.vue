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
                    id: '',
                    address: '',
                    applicant: '',
                    assignedTo: '',
                    attachedContent: '',
                    breakdown: '',
                    enrolment: '',
                    deadline: '',
                    description: '',
                    district: '',
                    title: '',
                    neighborhood:'',
                    publicCenter: '',
                    responseForCitizen: '',
                    state: '',
                    street: '',
                    tag: '',
                    team: '',
                    user: '',
                    area: '',
                },
                roles:[],
                workers:[],
                enrollments:[],
                states:[],
                images: [],
                areas: [],
                tags: [],
                uri:'admin/incidence',
                method: 'PUT',
                route:'/incidences'
            }
        };
  },
  components:{
      FormIncidence
  },
  mounted() {
      this.getIncidenceById( this.$route.params.id );
      this.getData();
  },
  methods: {
      getData() {
          axios.get(window.origin+'/admin/incidence/form-data/')
              .then(response=>{
                  let data = response.data;
                  this.formIn.areas = data.areas;
                  this.formIn.states = data.states;
                  this.formIn.enrolemnts = data.enrolments;
                  this.formIn.public_centers = data.public_centers;
                  this.formIn.streets = data.streets;
                  this.formIn.neighborhoods = data.neighborhoods;
                  this.formIn.equipments = data.equipments;
                  this.formIn.priorities = data.priorities;
                  this.formIn.workers = data.workers;
                  this.formIn.tags = data.tags;
                  this.formIn.form._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                  this.formIn.uri = this.formIn.uri+'/'+response.data.id;
              })
      },
      getIncidenceById(id) {
          axios.get(window.origin+'/admin/incidences/'+id)
          .then(response=>{
              let data = response.data.incidence;
              this.formIn.form = data;
              this.formIn.form.state =  data.state ? data.state.id : null;
              this.formIn.form.area =  data.area ? data.area.id : null;
              this.formIn.form.tag =  data.tag ? data.tag.id : null;
              this.formIn.form.enrolment =  data.enrolment ? data.enrolment.id : null
              this.formIn.form.public_center =  data.public_center ? data.public_center.id : null;
              this.formIn.form.assignedTo =  data.assignedTo ? data.assignedTo.id : null;
              this.formIn.images = data.images;
              this.formIn.form.images = [];

              this.formIn.form._token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              this.formIn.uri = this.formIn.uri+'/'+response.data.id;
          })
      }
    }
}
</script>

<style scoped>

</style>
