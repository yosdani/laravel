<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.areas.add_worker')}}</h3>
            </b-card-header>
            <b-card-body>
                <b-list-group>
                    <b-list-group-item v-for="worker in workers" :key="worker.id" @click="selectWorker(worker.id)" button>{{ worker.name }}</b-list-group-item>
                </b-list-group>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
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
              text: trans.translate('general.areas.add_worker'),
              active: true
          }
      ],
        workers : [],
        areaId:null
    };
  },
  components:{
  },
  mounted() {
      this.getWorkers();
      this.areaId = this.$route.params.id;
  },
  methods:{
      getWorkers(){
          axios.get(window.origin+'/admin/workers/select')
          .then(response =>{
              this.workers = response.data.workers;
          })
      },
      selectWorker(id){
          let body = {
              'id' : id
          }
          axios.post(window.origin+'/admin/workers/area/'+this.areaId,body)
          .then(response =>{
              this.getWorkers();
          })
          .catch(error =>{
              this.$swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: error,
              })
          })
      }
  }
}
</script>

<style scoped>

</style>
