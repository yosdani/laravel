<template>
    <b-form @submit="onSubmit" v-if="show">
        <input type="hidden" name="_token" :value="form._token" />
        <b-row>
            <b-col md="6">
                <b-form-group id="input-group-2" :label="translate('general.news.title')" label-for="input-2">
                    <b-form-input
                        id="input-2"
                        v-model="form.title"
                        :placeholder="translate('general.news.title')"
                        required
                    ></b-form-input>
                </b-form-group>

                <b-form-group id="input-group-3" :label="translate('general.incidences.add_area')" label-for="input-3">
                    <b-form-select v-model="formOut.form.area">
                        <template #first>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="area in formOut.areas" :key="area.id" :value="area.id">{{ area.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>

                 <b-form-group id="input-group-4" :label="translate('general.incidences.add_tag')" label-for="input-4">
                     <b-form-select v-model="formOut.form.tags">
                         <template #first>
                             <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                         </template>
                         <b-form-select-option  v-for="tag in formOut.tags" :key="tag.id" :value="tag.id">{{ tag.name }}</b-form-select-option>
                     </b-form-select>
                   </b-form-group>
                    </b-col>
                    <b-col cols="6">
                        <b-form-group id="input-group-5" :label="translate('general.incidences.state')" label-for="input-5">
                            <b-form-select v-model="formOut.form.state">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                                </template>
                                <b-form-select-option  v-for="state in formOut.states" :key="state.id" :value="state.id">{{ state.name }}</b-form-select-option>
                            </b-form-select>
                        </b-form-group>

                        <b-form-group id="input-group-6" :label="translate('general.enrolments.enrolment')" label-for="input-6">
                            <b-form-select v-model="formOut.form.enrollment">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                                </template>
                                <b-form-select-option  v-for="enrolment in formOut.enrolments" :key="enrolment.id" :value="enrolment.id">{{ enrolment.name }}</b-form-select-option>
                            </b-form-select>
                        </b-form-group>

                        <b-form-group id="input-group-7" :label="translate('general.incidences.add_worker')" label-for="input-7">
                            <b-form-select v-model="formOut.form.workers">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                                </template>
                                <b-form-select-option  v-for="worker in formOut.workers" :key="worker.id" :value="worker.id">{{ worker.name }} {{ worker.lastname }}</b-form-select-option>
                            </b-form-select>
                        </b-form-group>
                        <b-form-group id="input-group-images" :label="translate('general.incidences.images')" label-for="input-3">
                            <b-form-file
                                @change="onFileChange"
                                :placeholder="translate('general.select_file')"
                                :drop-placeholder="translate('general.drop_file')"
                                multiple
                            ></b-form-file>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col cols="12">
                        <b-button type="submit" variant="primary">{{formOut.action}}</b-button>
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
            show: true
        };
    },
    updated() {
        this.form = this.formOut.form;
    },
    methods: {
      onSubmit(event) {
          let vm = this;
          event.preventDefault()
          axios({
              method: vm.formOut.method,
              url: window.origin+'/admin/incidences/'+this.formOut.form.id,
              data: this.formOut.form,
              headers: {'content-type': 'application/json'}
          }).then(response => {
                  this.$swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: this.formOut.actionMessage + this.formOut.formFrom.toLowerCase(),
                      showConfirmButton: false,
                      timer: 1500
                  })
                  this.onReset(event);
                  this.$router.push(this.formOut.route);
              },
              (error) => {
                  this.$swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: trans.translate('general.error_message'),
                  })
              });
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
      },
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)return;
            this.createImage(files);
        },
        createImage(file) {
            let vm = this;
            vm.formOut.form.images = [];
            if(typeof FileReader==='undefined'){
                alert('Su navegador no admite carga de imágenes, actualice su navegador');
                return false;
            }

            for(var i=0;i<file.length;i++){
                var reader = new FileReader();
                reader.readAsDataURL(file[i]);
                reader.onload =function(e){
                    vm.formOut.form.images.push(e.target.result);
                };
            }
        }
    }
}
</script>

<style scoped>

</style>
