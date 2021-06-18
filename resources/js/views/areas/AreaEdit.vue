<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.areas.area')}}</h3>
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
              text: trans.translate('general.areas.areas'),
              to: { name: 'areas' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom: trans.translate('general.areas.areas'),
        label: trans.translate('general.name'),
        placeholder: '',
        action: trans.translate('general.save'),
        form: {
            name: '',
            user_id: ''
        },
        array:[],
        uri:'admin/areas',
        method: 'PUT',
        route:'/areas'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getAreaById( this.$route.params.id );
      this.getResponsables();
  },
  methods:{
      getAreaById(id) {
          axios.get('/admin/areas/'+id)
          .then(response => {
              this.formIn.form.name = response.data.name;
              this.formIn.form.user_id = response.data.user_id;
              this.formIn.uri = this.formIn.uri+'/'+response.data.id;
          })
      },
      getResponsables(){
          axios.get(window.origin+'/admin/responsables/areas')
          .then(response =>{
            response.data.responsables.map(r=>{
                this.formIn.array.push({
                    text: r.email,
                    value: r.id
                })
            })
          })
      }
  }
}
</script>

<style scoped>

</style>
