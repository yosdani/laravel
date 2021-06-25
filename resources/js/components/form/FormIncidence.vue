<template>
    <div class="text-center myLoading" v-if="loading">
        <b-spinner class="align-middle"></b-spinner>
        <strong>{{ translate('general.loading') }}</strong>
    </div>
    <b-form @submit="onSubmit" v-else>
        <input type="hidden" name="_token" :value="formOut.form._token" />
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
                <b-form-group id="input-group-3" :label="translate('general.incidences.responseForCitizen')" label-for="input-3">
                    <b-textarea
                        id="input-2"
                        v-model="form.responseForCitizen"
                        :placeholder="translate('general.incidences.responseForCitizen')"
                        rows="3"
                    ></b-textarea>
                </b-form-group>
                <b-form-group id="input-group-3" :label="translate('general.incidences.public_center')" label-for="input-3">
                    <b-form-select v-model="form.public_center">
                        <template>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="pc in formOut.public_centers" :key="pc.id" :value="pc.id">{{ pc.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>
                <b-form-group :label="translate('general.incidences.street')" label-for="input-3">
                    <b-form-select v-model="form.street">
                        <template>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="street in formOut.streets" :key="street.id" :value="street.id">{{ street.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>
                <b-form-group :label="translate('general.incidences.neighbor')" label-for="input-3">
                    <b-form-select v-model="form.neighborhood">
                        <template>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="neighborhood in formOut.neighborhoods" :key="neighborhood.id" :value="neighborhood.id">{{ neighborhood.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>
            </b-col>
            <b-col cols="6">
                <b-form-group id="input-group-5" :label="translate('general.incidences.state')" label-for="input-5">
                    <b-form-select v-model="form.state">
                        <template>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="state in formOut.states" :key="state.id" :value="state.id">{{ state.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>
                <b-form-group id="input-group-3" :label="translate('general.incidences.add_area')" label-for="input-3">
                    <b-form-select v-model="form.area">
                        <template>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="area in formOut.areas" :key="area.id" :value="area.id">{{ area.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>
                <b-form-group id="input-group-4" :label="translate('general.incidences.add_tag')" label-for="input-4">
                    <b-form-select v-model="form.tag">
                        <template>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="tag in formOut.tags" :key="tag.id" :value="tag.id">{{ tag.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>
                <b-form-group id="input-group-6" :label="translate('general.enrolments.enrolment')" label-for="input-6">
                    <b-form-select v-model="form.enrolment">
                        <template>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="enrolment in formOut.enrolments" :key="enrolment.id" :value="enrolment.id">{{ enrolment.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>

                <b-form-group id="input-group-7" :label="translate('general.incidences.add_worker')" label-for="input-7">
                    <b-form-select v-model="form.assignedTo">
                        <template>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="worker in formOut.workers" :key="worker.id" :value="worker.id">{{ worker.name }} {{ worker.lastname }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>
            </b-col>
        </b-row>
        <b-container fluid>
            <b-row>
                <b-col md="12">
                    <h4>{{ translate('general.incidences.images') }}</h4>
                </b-col>
                <b-col md="4">
                    <b-form-group id="input-group-images" :label="translate('general.add') + ' ' + translate('general.incidences.images')" label-for="image-new">
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
                <b-col md="4" v-for="image in formOut.images" :key="image.id">
                    <b-form-group>
                        <a :href="image.url">
                            <b-img thumbnail fluid :src="image.url"></b-img>
                        </a>
                        <b-btn @click="removeImage(image.id)" size="sm" variant="danger" class="remove-btn">
                            <b-icon icon="trash-fill"></b-icon>
                        </b-btn>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-container>
        <b-row>
            <b-col cols="12">
                <b-button type="submit" variant="primary">{{formOut.action}}</b-button>
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
            tagSearch: ''
        };
    },
    updated() {
        this.form = this.formOut.form;
    },
    computed: {
        ...mapState({
            loading: state => state.loadingBody
        }),
        criteria() {
            // Compute the search criteria
            return this.tagSearch.trim().toLowerCase()
        },
        availableOptions() {
            const criteria = this.criteria
            // Filter out already selected options
            const options = this.formOut.tags.filter(opt => this.name.indexOf(opt) === -1)
            if (criteria) {
                // Show only options that match criteria
                return options.filter(opt => opt.toLowerCase().indexOf(criteria) > -1);
            }
            // Show all options available
            return options
        },
        searchDesc() {
            if (this.criteria && this.availableOptions.length === 0) {
                return 'No existen etiquetas con ese nombre'
            }
            return ''
        }
    },
    methods: {
        onSubmit(event) {
            let vm = this;
            event.preventDefault()
            vm.$store.dispatch('setLoadingBody', true);
            axios({
                method: vm.formOut.method,
                url: window.origin+'/admin/incidences/'+this.formOut.form.id,
                data: this.formOut.form,
                headers: {'content-type': 'application/json'}
            }).then(response => {
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
                },
                (error) => {
                    vm.$store.dispatch('setLoadingBody', false);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: trans.translate('general.error_message'),
                    })
                });
        },
        onOptionClick({ option, addTag }) {
            addTag(option)
            this.tagSearch = ''
        },
        removeImage(id){
            let vm = this;
            vm.$store.dispatch('setLoadingBody', true);
            axios.get(window.origin+'/admin/incidence/remove-image/'+id)
                .then(response => {
                        vm.formOut.images = vm.form.images.filter(function (obj) {
                            return obj.id !== id;
                        });
                    vm.$store.dispatch('setLoadingBody', false);
                    this.$swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: this.formOut.actionMessage + this.formOut.formFrom.toLowerCase(),
                        showConfirmButton: false,
                        timer: 1500
                    })
                },
                (error) => {
                    vm.$store.dispatch('setLoadingBody', false);
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

            for(let i=0;i<file.length;i++){
                let reader = new FileReader();
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
  .remove-btn{
      position: absolute;
      right: 25px;
      top: 10px;
  }
</style>
