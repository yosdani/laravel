<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.roles.roles')}}</h3>
            </b-card-header>
            <b-card-body class="row">
                <b-card class="col-lg-2 col-md-6 card-roles" v-for="(item) in items" :key="item.id">
                    <b-avatar class="avatar-roles-edit" variant="info"></b-avatar>
                    <div class="mb-2">{{item.name}}</div>
                    <a class="actions-roles-edit" :id="'icon-edit-role_'+item.id" @click="editRole(item.id)"><b-icon  icon="cloud-upload" aria-hidden="true"></b-icon></a>
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
import trans from '../../VueTranslation/Translation';
export default {
  data() {
    return {
      items: [],
      bItems: [
          {
              text: trans.translate('general.dashboard'),
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.roles.roles'),
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
      axios.get("/admin/roles")
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
            confirmButtonText: 'Si, eliminar!',
        }).then((result) => {
            if(result.isConfirmed){
                axios.delete(window.origin+'/admin/roles/'+item)
                    .then(result => {
                        this.fetchData();
                        this.$swal.fire(
                            'Eliminado!',
                            'El Rol ha sido eliminado.',
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
    },
    editRole(item){
        this.$router.push('/roles/edit/'+item);
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
