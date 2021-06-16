<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>
        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Perfil de usuario</h3>
            </b-card-header>
            <b-card-body>
                <b-row>
                    <b-col size="6">
                        <b-card>
                            <b-card-body>
                                <p class="text-capitalize">Nombre: {{ user.name }} </p>
                                <p class="text-capitalize">Apellidos: {{ user.lastName }}</p>
                                <p><span class="text-capitalize">Email:</span> {{ user.email }}</p>
                            </b-card-body>
                        </b-card>
                    </b-col>
                    <b-col size="6">
                        <b-button v-b-toggle.collapse-1 variant="primary">Editar perfil</b-button>
                        <b-collapse id="collapse-1" class="mt-2">
                            <b-card>
                                <b-card-body>
                                    <b-form @submit="onSubmit" @reset="onReset">
                                        <b-form-group
                                            id="input-group-1"
                                            label="Nombre:"
                                            label-for="name"
                                        >
                                            <b-form-input
                                                id="name"
                                                v-model="form.name"
                                                type="text"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group
                                            id="input-group-2"
                                            label="Apellidos:"
                                            label-for="lastname"
                                        >
                                            <b-form-input
                                                id="lastname"
                                                v-model="form.lastName"
                                                type="text"
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group
                                            id="input-group-3"
                                            label="Email address:"
                                            label-for="email"
                                        >
                                            <b-form-input
                                                id="email"
                                                v-model="form.email"
                                                type="email"
                                                required
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group
                                            id="input-group-4"
                                            label="Contraseña:"
                                            label-for="password"
                                        >
                                            <b-form-input
                                                id="password"
                                                v-model="form.password"
                                                type="password"
                                                placeholder="Contraseña"
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group
                                            id="input-group-5"
                                            label="Repita la Contraseña:"
                                            label-for="password_repeat"
                                        >
                                            <b-form-input
                                                id="password_repeat"
                                                v-model="form.password_repeat"
                                                type="password"
                                                placeholder="Repita la  contraseña para cambiarla"
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-button type="submit" variant="primary">Guardar</b-button>
                                    </b-form>

                                </b-card-body>
                            </b-card>
                        </b-collapse>

                    </b-col>
                </b-row>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import {mapState} from "vuex";

export default {
    data(){
        return {
            form: {
                email: null,
                name: null,
                lastName: null,
                password: null,
                password_repeat: null,
                _token: null
            },
            bItems: [
                {
                    text: 'Dashboard',
                    to: { name: 'dashboard' }
                },
                {
                    text: 'Perfil',
                    active: true
                }
            ],
        }
    },
    computed:{
      ...mapState({
             user: state => state.user
      }),
    },
    created(){
        this.form.email = this.$store.state.user.email;
        this.form.name = this.$store.state.user.name;
        this.form.lastName = this.$store.state.user.lastName;
        this.form._token = this.user._token;
    },
    methods:{
        onSubmit(event){
            event.preventDefault()
            let vm = this;
                if(null != vm.form.password_repeat &&
                    0 < vm.form.password_repeat.length &&
                    vm.form.password !== vm.form.password_repeat){
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Las contraseñas no coinciden!',
                    })
                }else{
                    let payload = { ...vm.form }
                    if(null == vm.form.password_repeat || 0 === vm.form.password_repeat.length){
                        payload.password = null;
                    }
                    fetch(window.origin+'/admin/change-password',{
                        method: 'POST',
                        headers:{
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                        .then(response => response.json())
                        .then(response=>{
                            if(response.success){
                                vm.$store.dispatch('updateUser', response.user);
                                this.$swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Sus datos se han modificado correctamente',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }else{
                                this.$swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                })
                            }

                        })
                        .catch(err =>{
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            })
                        })
                }
        },
        onReset(){

        }
    }
}
</script>

<style scoped>

</style>
