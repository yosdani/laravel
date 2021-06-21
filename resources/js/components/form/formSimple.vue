<template>
    <b-form @submit="onSubmit" v-if="show">
        <input type="hidden" name="_token" :value="csrf">
        <b-row>
            <b-col cols="6">
                <b-form-group v-if="formOut.formFrom != translate('general.streets.street')" id="input-group-1" :label="formOut.label" label-for="input-1">
                    <b-form-input
                        id="input-1"
                        v-model="form.name"
                        :placeholder="formOut.placeholder"
                        :required="formOut.required"
                    ></b-form-input>
                </b-form-group>

                <b-form-group v-if="formOut.formFrom == translate('general.streets.street')" id="input-group-2" :label="formOut.label" label-for="input-2">
                    <b-form-input
                        id="input-2"
                        v-model="form.street"
                        :placeholder="formOut.placeholder"
                        :required="formOut.required"
                    ></b-form-input>
                </b-form-group>

                <b-form-group v-if="formOut.formFrom == translate('general.streets.street')" id="input-group-3" :label="translate('general.streets.number')" label-for="input-3">
                    <b-form-input
                        type="number"
                        id="input-3"
                        v-model="form.number"
                        :placeholder="translate('general.streets.number')"
                        :required="formOut.required"
                    ></b-form-input>
                </b-form-group>

                <b-form-group v-if="formOut.formFrom == translate('general.areas.area')" id="input-group-4" :label="translate('general.areas.add_resp')" label-for="input-4">
                    <b-form-select
                        id="input-4"
                        v-model="form.user_id"
                        :options="formOut.array"
                    ></b-form-select>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col size="12">
                <b-button type="submit" variant="primary">{{ formOut.action }}</b-button>
            </b-col>

        </b-row>
    </b-form>
</template>

<script>
import trans from "../../VueTranslation/Translation";

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
