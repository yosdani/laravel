<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>
        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{ translate('general.users.user_profile') }}</h3>
            </b-card-header>
            <b-card-body>
                <b-row>
                    <b-col size="6">
                        <b-card>
                            <b-card-body>
                                <p class="text-capitalize">{{ translate('general.users.name') }}: {{ user.name }} </p>
                                <p class="text-capitalize">{{ translate('general.users.lastname') }}: {{ user.lastName }}</p>
                                <p><span class="text-capitalize">{{ translate('general.users.email') }}:</span> {{ user.email }}</p>
                            </b-card-body>
                        </b-card>
                    </b-col>
                    <b-col size="6">
                        <b-button v-b-toggle.collapse-1 variant="primary">{{ translate('general.edit') }} {{ translate('general.users.profile') }}</b-button>
                        <b-collapse id="collapse-1" class="mt-2">
                            <b-card>
                                <b-card-body>
                                    <b-form @submit="onSubmit" @reset="onReset">
                                        <b-form-group
                                            id="input-group-1"
                                            :label="translate('general.users.name')"
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
                                            :label="translate('general.users.lastName')"
                                            label-for="lastName"
                                        >
                                            <b-form-input
                                                id="lastName"
                                                v-model="form.lastName"
                                                type="text"
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group
                                            id="input-group-3"
                                            :label="translate('general.users.email')"
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
                                            :label="translate('general.users.password')"
                                            label-for="password"
                                        >
                                            <b-form-input
                                                id="password"
                                                v-model="form.password"
                                                type="password"
                                                :placeholder="translate('general.users.password')"
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-form-group
                                            id="input-group-5"
                                            :label="translate('general.users.profile_change_password')"
                                            label-for="password_repeat"
                                        >
                                            <b-form-input
                                                id="password_repeat"
                                                v-model="form.password_repeat"
                                                type="password"
                                                :placeholder="translate('general.users.password')"
                                            ></b-form-input>
                                        </b-form-group>
                                        <b-button type="submit" variant="primary">{{ translate('general.save') }}</b-button>
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
                    text: trans.translate('general.dashboard'),
                    to: { name: 'dashboard' }
                },
                {
                    text: trans.translate('general.users.profile'),
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
                        text: trans.translate('general.users.profile_pass_mismatch'),
                    })
                }else{
                    let payload = { ...vm.form }
                    if(null == vm.form.password_repeat || 0 === vm.form.password_repeat.length){
                        payload.password = null;
                    }
                    axios.post(window.origin+'/admin/change-password',
                        payload).then(response => {
                        if(response.data.success){
                            vm.$store.dispatch('updateUser', response.data.user);
                            this.$swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: trans.translate('general.users.profile_success'),
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }else{
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.data.message,
                            })
                        }
                    },(error)=>{
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: trans.translate('general.error_message'),
                        })
                    });
                }
        },
        onReset(){

        }
    }
}
</script>

<style scoped>

</style>
