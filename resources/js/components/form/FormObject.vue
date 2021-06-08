<template>
    <b-form @submit="onSubmit" v-if="show">
                <input type="hidden" name="_token" :value="csrf">
                    <b-form-group
                        v-if="formOut.formFrom=='User'"
                        id="input-group-1"
                        label="Entre el email"
                        label-for="input-1"
                    >
                        <b-form-input
                        id="input-1"
                        v-model="form.email"
                        type="email"
                        placeholder="Entre el email"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-2" label="Entre el nombre:" label-for="input-2">
                        <b-form-input
                        id="input-2"
                        v-model="form.name"
                        placeholder="Entre el nombre"
                        required
                        ></b-form-input>
                    </b-form-group>

                     <b-form-group v-if="formOut.formFrom=='User'" id="input-group-3" label="Entre sus apellidos:" label-for="input-3">
                        <b-form-input
                        id="input-3"
                        v-model="form.lastName"
                        placeholder="Entre sus apellidos"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group v-if="formOut.formFrom=='User'" id="input-group-4" label="Entre su numero telefonico:" label-for="input-4">
                        <b-form-input
                        id="input-4"
                        v-model="form.phoneNumber"
                        placeholder="Entre su numero telefonico"
                        ></b-form-input>
                    </b-form-group>

                     <b-form-group v-if="formOut.formFrom=='User'" id="input-group-4" label="Entre la contraseña:" label-for="text-password">
                        <b-form-input type="password" id="text-password" aria-describedby="password-help-block"></b-form-input>
                    </b-form-group>

                    <b-form-group v-if="formOut.formFrom=='User'" id="input-group-3" label="Entre el rol del usuario:" label-for="input-3">
                        <b-form-select
                        id="input-3"
                        v-model="form.role"
                        :options="formOut.roles"
                        required
                        ></b-form-select>
                    </b-form-group>

                    <b-button type="submit" variant="primary">Submit</b-button>
                </b-form>
</template>

<script>
export default {
    props: ["formOut"],
    data() {
        return {
            form: {},
            show: true,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    },
    mounted() {
        this.form = this.formOut.form;
        this.form._token = this.csrf;
    },
    methods: {
      onSubmit(event) {
        event.preventDefault()
        fetch(window.origin+'/'+this.formOut.uri,{
            method: this.formOut.method,
            headers:{
                'content-type': 'application/json'
            },
            body: JSON.stringify(this.form)
        })
        .then(response => response.json())
        .then(response=>{
            this.$swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Se ha adicionado correctamente',
                showConfirmButton: false,
                timer: 1500
            })
            this.onReset(event);
        })
        .catch(err =>{
            this.$swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        })
      },
      onReset(event) {
        event.preventDefault()
        // Reset our form values
        this.form = this.formOut;
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      }
    }
}
</script>

<style scoped>

</style>