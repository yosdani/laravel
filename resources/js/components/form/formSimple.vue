<template>
    <div class="text-center myLoading" v-if="loading">
        <b-spinner class="align-middle"></b-spinner>
        <strong>{{ translate('general.loading') }}</strong>
    </div>
    <b-form @submit="onSubmit" v-else>
        <input type="hidden" name="_token" :value="csrf">
        <b-row>
            <b-col md="6">
                <b-form-group v-if="formOut.formFrom !== translate('general.streets.street')"  id="input-group-2" :label="formOut.label" label-for="input-2">
                    <b-form-input
                        id="input-2"
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
import {mapState} from "vuex";
export default {
    props: ["formOut"],
    data() {
        return {
            form: {},
            show: true,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    },
    computed: {
        ...mapState({
            loading: state => state.loadingBody
        }),
    },
    mounted() {
        this.form = this.formOut.form;
        this.form._token = this.csrf;
    },
    methods: {
      onSubmit(event) {
          event.preventDefault()
          let vm = this;
          vm.$store.dispatch('setLoadingBody', true);
          axios(window.origin+'/'+this.formOut.uri,{
              method: this.formOut.method,
              headers:{'content-type': 'application/json'},
              data: JSON.stringify(this.form)
          })
              .then(response=>{
                  vm.$store.dispatch('setLoadingBody', false);
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
                  vm.$store.dispatch('setLoadingBody', false);
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
