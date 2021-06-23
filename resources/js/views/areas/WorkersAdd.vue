<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.areas.add_worker')}}</h3>
            </b-card-header>
            <b-card-body>
                <h4 v-if="workers.length == 0">
                    {{ translate('general.areas.workers_area.not_workers')}} </h4>
                <b-list-group v-else>
                    <b-list-group-item
                        v-for="worker in workers" 
                        :key="worker.id" 
                        @click="selectWorker(worker.id)" 
                        button
                    >{{ worker.name }}
                    <b-icon class="float-right icon-add-workers" icon="plus-circle" aria-hidden="true"></b-icon>    
                </b-list-group-item>
                </b-list-group>
                <div class="line-divisor"></div>
                <b-list-group>
                    <b-list-group-item 
                        v-for="worker in workersAdd" 
                        :key="worker.id" 
                        button
                        @click="deleteWorker(worker.id)"
                    >{{ worker.name }}
                    <b-icon class="float-right icon-workers" icon="trash-fill" aria-hidden="true"></b-icon>
                    </b-list-group-item>
                </b-list-group>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import trans from '../../VueTranslation/Translation'
export default {
    data() {
    return {
      bItems: [
          {
              text: trans.translate('general.dashboard'),
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
        workersAdd : [],
        areaId:null
    };
  },
  components:{
  },
  mounted() {
      this.getWorkers();
      this.areaId = this.$route.params.id;

      this.workersArea();
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
              this.workersArea();
              this.$swal.fire({
                position: 'top-end',
                icon: 'success',
                title: trans.translate('general.areas.workers_area.add_success'),
                showConfirmButton: false,
                timer: 1500
            })
          })
          .catch(error =>{
              this.$swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: error,
              })
          })
      },
      workersArea(){
          axios.get(window.origin+'/admin/workers/area/'+this.areaId)
          .then( response => {
              this.workersAdd = response.data.workers.workers;
          })
      },
      deleteWorker(id) {
        this.$swal.fire({
            title: trans.translate('general.are_you_sure'),
            text: trans.translate('general.not_reversible'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: trans.translate('general.yes')
            }).then((result) => {
            if(result.isConfirmed) {
                axios.delete(window.origin+'/admin/worker/'+id+'/area')
                .then(result => {
                    this.getWorkers();
                    this.workersArea();
                this.$swal.fire(
                    trans.translate('general.deleted'),
                    'success'
                )
                })
                .catch(error =>{
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error,
                })
                })
            }
        })
      }

  }
}
</script>

<style scoped>
.line-divisor{
    border-top: 2px solid #cccc;
    margin-top: 20px;
    margin-bottom: 20px;
}
.icon-workers{
    fill :darkred;
}
.icon-add-workers{
    fill :dodgerblue;
}
</style>
