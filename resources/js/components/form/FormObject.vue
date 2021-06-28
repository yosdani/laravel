<template>
    <b-form @submit="onSubmit" v-if="show">
                <input type="hidden" name="_token" :value="csrf">
        <b-row>
            <b-col md="6">
                    <b-form-group
                        v-if="formOut.formFrom == translate('general.users.user')"
                        id="input-group-1"
                        :label="translate('general.users.email')"
                        label-for="input-1"
                    >
                        <b-form-input
                        id="input-1"
                        v-model="form.email"
                        type="email"
                        placeholder="example@domain.com"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-2" :label="translate('general.users.name')" label-for="input-2">
                        <b-form-input
                        id="input-2"
                        v-model="form.name"
                        :placeholder="translate('general.users.name')"
                        required
                        ></b-form-input>
                    </b-form-group>

                     <b-form-group v-if="formOut.formFrom == translate('general.users.user')" id="input-group-3" :label="translate('general.users.lastName')" label-for="input-3">
                        <b-form-input
                        id="input-3"
                        type="text"
                        v-model="form.lastName"
                        :placeholder="translate('general.users.lastName')"
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group v-if="formOut.formFrom == translate('general.users.user')" id="input-group-4" :label="translate('general.users.phone')" label-for="input-4">
                        <b-form-input
                        id="input-4"
                        type="text"
                        v-model="form.phoneNumber"
                        placeholder="0123456789"
                        ></b-form-input>
                    </b-form-group>

                     <b-form-group v-if="formOut.formFrom == translate('general.users.user')" id="input-group-4" :label="translate('general.users.password')" label-for="text-password">
                        <b-form-input type="password" id="text-password" aria-describedby="password-help-block"></b-form-input>
                    </b-form-group>

                    <b-form-group v-if="formOut.formFrom == translate('general.users.user')" id="input-group-3" :label="translate('general.roles.role')" label-for="input-3">
                        <b-form-select v-model="formOut.form.role" required>
                            <template #first>
                                <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                            </template>
                            <b-form-select-option  v-for="role in formOut.roles" :key="role.id" :value="role.id">{{ role.name }}</b-form-select-option>
                        </b-form-select>
                    </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col cols="12">
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
        axios(window.origin+'/'+this.formOut.uri,{
            method: this.formOut.method,
            headers:{'content-type': 'application/json'},
            data: JSON.stringify(this.form)
        })
        .then(response=>{
            this.$swal.fire({
                position: 'top-end',
                icon: 'success',
                title: this.formOut.actionMessage + this.formOut.formFrom.toLowerCase(),
                showConfirmButton: false,
                timer: 1500
            })
            this.onReset(event);
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
