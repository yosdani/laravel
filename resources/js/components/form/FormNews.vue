<template>
    <div class="text-center myLoading" v-if="loading">
        <b-spinner class="align-middle"></b-spinner>
        <strong>{{ translate('general.loading') }}</strong>
    </div>
    <form @submit="onSubmit" v-else enctype="multipart/form-data">
        <b-row>
            <b-col md="6">
                <b-form-group id="input-group-2" :label="translate('general.news.title')" label-for="input-2">
                    <b-form-input
                        id="input-2"
                        v-model="formOut.form.title"
                        :placeholder="translate('general.news.title')"
                        required
                    ></b-form-input>
                </b-form-group>

                <b-form-group id="input-group-3" :label="translate('general.news.subtitle')" label-for="input-3">
                    <b-form-input
                        id="input-3"
                        v-model="formOut.form.subtitle"
                        :placeholder="translate('general.news.subtitle')"
                    ></b-form-input>
                </b-form-group>

                <b-form-group id="input-group-4" :label="translate('general.news.content')" label-for="input-4">
                    <b-form-textarea
                        id="textarea-default"
                        v-model="formOut.form.content"
                        :placeholder="translate('general.news.content')"
                        required
                        rows="10"
                    ></b-form-textarea>
                </b-form-group>
            </b-col>
            <b-col md="6">
                <b-form-group id="input-group-category" :label="translate('general.categories.categories')" label-for="input-3">
                    <b-form-select v-model="formOut.form.category_id" required>
                        <template #first>
                            <b-form-select-option :value="null" disabled>-- {{ translate('general.select') }} --</b-form-select-option>
                        </template>
                        <b-form-select-option  v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</b-form-select-option>
                    </b-form-select>
                </b-form-group>
                <b-form-group id="input-group-images" :label="translate('general.news.images')" label-for="input-3">
                    <b-form-file
                        @change="onFileChange"
                        :placeholder="translate('general.select_file')"
                        :drop-placeholder="translate('general.drop_file')"
                        multiple
                    ></b-form-file>
                </b-form-group>
            </b-col>
        </b-row>

        <b-button type="submit" variant="primary">{{ formOut.action }}</b-button>

    </form>
</template>

<script>
import trans from '../../VueTranslation/Translation';
import {mapState} from "vuex";
export default {
    props: ["formOut"],
    data() {
        return {
            images:[],
            show: true,
            img: null,
            categories: []
        };
    },
    created() {
        this.getCategories();
    },
    computed: {
        ...mapState({
            loading: state => state.loadingBody
        }),
    },
    methods: {
      onSubmit(event) {
        let vm = this;
        event.preventDefault();
        vm.$store.dispatch('setLoadingBody', true);
          axios({
              method: vm.formOut.method,
              url: window.origin+'/'+vm.formOut.uri,
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
      onReset(event) {
        event.preventDefault()
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
        getCategories(){
          let vm = this;
            axios.get(window.origin+'/admin/category/all')
            .then(response=>{
               vm.categories = response.data.category;
            })
            .catch(err =>{
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
img {
        width: 100px;
        height: 100px;
        margin: auto;
        display: inline;
        margin-bottom: 10px;
    }
</style>
