<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.neighborhoods.neighborhood')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-simple :formOut="formIn"></form-simple>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormSimple from '../../components/form/formSimple.vue';
export default {
    data() {
    return {
      bItems: [
          {
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.neighborhoods.neighborhoods'),
              to: { name: 'neighborhood' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom:trans.translate('general.neighborhoods.neighborhood'),
        label: trans.translate('general.name'),
        placeholder: trans.translate('general.name'),
        action: trans.translate('general.save'),
        form: {
            name: ''
        },
        uri:'admin/neighborhood',
        method: 'PUT',
        route:'/neighborhood'
      }
    };
  },
  components:{
    FormSimple
  },
  mounted() {
      this.getNeighborhoodById( this.$route.params.id );
  },
  methods:{
      getNeighborhoodById(id) {
          axios.get('/admin/neighborhood/'+id)
          .then(response => {
              this.formIn.form.name = response.data.neighborhood.name;
              this.formIn.uri = this.formIn.uri+'/'+response.data.neighborhood.id;
          })
      }
  }
}
</script>

<style scoped>

</style>
