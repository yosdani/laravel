<template>
    <form @submit="onSubmit" v-if="show" enctype="multipart/form-data">
        <b-row>
            <b-col size="6">
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
                    ></b-form-textarea>
                </b-form-group>
            </b-col>
            <b-col size="6">
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
    methods: {
      onSubmit(event) {
        let vm = this;
        event.preventDefault();
        fetch(window.origin+'/'+vm.formOut.uri,{
            method: vm.formOut.method,
            headers:{
                'content-type': 'application/json'
            },
            body: JSON.stringify(this.formOut.form)
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
                text: 'Something went wrong!',
            })
        })
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
            fetch(window.origin+'/admin/category/all',{
                method: 'GET',
                headers:{
                    'content-type': 'application/json'
                },
            }).then(response => response.json())
                .then(response=>{
                   vm.categories = response.category;
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
