<template>
    <b-form @submit="onSubmit" v-if="show">
                <input type="hidden" name="_token" :value="form._token" />

                    <b-form-group id="input-group-2" :label="translate('general.news.title')" label-for="input-2">
                        <b-form-input
                        id="input-2"
                        v-model="form.name"
                        :placeholder="translate('general.news.title')"
                        required
                        ></b-form-input>
                    </b-form-group>

                   <!-- <b-form-group id="input-group-3" label="Asignar Área:" label-for="input-3">
                        <b-form-select
                        id="input-3"
                        v-model="form.area"
                        :options="formOut.areas"
                        required
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-3" label="Asignar etiqueta:" label-for="input-3">
                        <b-form-select
                        id="input-3"
                        v-model="form.etiqueta"
                        :options="formOut.etiquetas"
                        required
                        ></b-form-select>
                    </b-form-group>

                     <b-form-group v-if="formOut.formFrom=='User'" id="input-group-3" label="Entre sus apellidos:" label-for="input-3">
                        <b-form-input
                        id="input-3"
                        v-model="form.lastName"
                        placeholder="Entre sus apellidos"
                        ></b-form-input>
                    </b-form-group>-->

                    <b-form-group id="input-group-5" label="translate('general.incidences.state')" label-for="input-5">
                        <b-form-select
                        id="input-5"
                        v-model="form.state_id"
                        :options="formOut.states"
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-3" :label="translate('general.enrolments.enrolment')" label-for="input-3">
                        <b-form-select
                        id="input-3"
                        v-model="form.centerEnrollment"
                        :options="formOut.enrollments"
                        ></b-form-select>
                    </b-form-group>

                    <b-form-group id="input-group-4" :label="translate('general.incidences.add_worker')" label-for="input-4">
                        <b-form-select
                        id="input-4"
                        v-model="form.assignedTo"
                        :options="formOut.workers"
                        ></b-form-select>
                    </b-form-group>

                    <b-button type="submit" variant="primary">{{formOut.action}}</b-button>
                </b-form>
</template>

<script>
export default {
    props: ["formOut"],
    data() {
        return {
            form: {},
            show: true
        };
    },
    updated() {
        this.form = this.formOut.form;
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
                title: this.formOut.actionMessage + this.formOut.formFrom.toLowerCase(),
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
                text: trans.translate('general.error_message'),
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
