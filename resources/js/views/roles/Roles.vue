<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Roles</h3>
            </b-card-header>
            <b-card-body class="row">
                <b-card class="col-lg-2 col-md-6 card-roles" v-for="(item) in items" :key="item.id">
                    <b-avatar class="avatar-roles-edit" variant="info"></b-avatar>
                    <div class="mb-2">{{item.name}}</div>
                    <a class="actions-roles-edit" :id="'icon-edit-role_'+item.id" @click="editRole(item)"><b-icon  icon="cloud-upload" aria-hidden="true"></b-icon></a>
                    <b-tooltip :target="'icon-edit-role_'+item.id" triggers="hover">
                        Editar rol
                    </b-tooltip>
                    <a class="actions-roles-delete" :id="'icon-delete-role_'+item.id" @click="deleteRol(item.id)"><b-icon icon="trash-fill" aria-hidden="true"></b-icon></a>
                    <b-tooltip :target="'icon-delete-role_'+item.id" triggers="hover">
                        Eliminar rol
                    </b-tooltip>
                </b-card>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
export default {
  data() {
    return {
      items: [],
      bItems: [
          {
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: 'Roles',
              active: true
          }
      ],
        form:{
            id:'',
            name: ''
        }
    };
  },
  mounted() {
     this.fetchData();
  },
  methods: {
    fetchData(page=1) {
      let vm = this;
      fetch("/admin/roles")
        .then((response) => response.json())
        .then((response) => {
            vm.items = response;
        });
    },
    deleteRol(item) {
        this.$swal.fire({
          title: 'Está seguro?',
          text: "No va a ser posible revertir esta acción!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
          axios.delete(window.origin+'/admin/roles/'+item)
          .then(result => {
            this.fetchData();
            this.$swal.fire(
              'Deleted!',
              'Your file has been deleted.',
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
        })
    },
    editRole(item){
        this.$swal.fire({
          title: 'Editar el rol: '+item.name,
          input:'text',
          inputAttributes: {
                value: item.name
            },
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, editar!'
        }).then((result) => {
          axios.put(window.origin+'/admin/roles/'+item.id,item.name)
            then(response=>{
                this.$swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Se ha adicionado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                })
            })
            .catch(error=>{
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
            })
        })
    },
    editRol(item){
        
    }
  },
};
</script>

<style lang="scss" scoped>
.avatar-roles{
    width:70px;
    height:70px;
    margin-bottom: 10px;
}
.card-roles{
    margin-left: 20px;
}
.actions-roles-edit > svg{
    cursor: pointer;
    fill:darkslateblue;
}
.actions-roles-delete > svg{
    cursor: pointer;
    fill:brown;
}
</style>