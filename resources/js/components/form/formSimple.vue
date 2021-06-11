<template>
    <b-form @submit="onSubmit" v-if="show">
                <input type="hidden" name="_token" :value="csrf">

                    <b-form-group id="input-group-2" :label="formOut.label" label-for="input-2">
                        <b-form-input
                        id="input-2"
                        v-model="form.name"
                        :placeholder="formOut.placeholder"
                        :required="formOut.required"
                        ></b-form-input>
                    </b-form-group>

                    <b-button type="submit" variant="primary">{{ formOut.action }}</b-button>
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
                title: 'Se acaba de '+this.formOut.action+' correctamente',
                showConfirmButton: false,
                timer: 1500
            })
            this.onReset(event);
            this.$router.push(this.formOut.route);
        })
        .catch(err =>{
            this.$swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ha ocurrido un error!',
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