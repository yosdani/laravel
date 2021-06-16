<template>
    <b-form @submit="onSubmit" v-if="show">
                <input type="hidden" name="_token" :value="formOut.form._token" />
                    
                    <input @change="onFileChange" type="file" multiple name="photo" accept="image/*">

                    <b-form-group id="input-group-2" label="Título:" label-for="input-2">
                        <b-form-input
                        id="input-2"
                        v-model="formOut.form.title"
                        placeholder="Título de la noticia"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-3" label="Subtítulo:" label-for="input-3">
                        <b-form-input
                        id="input-3"
                        v-model="formOut.form.subTitle"
                        placeholder="Subtítulo de la noticia"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-4" label="Contenido:" label-for="input-4">
                        <b-form-textarea
                            id="textarea-default"
                            v-model="formOut.form.content"
                            placeholder="Contenido de la noticia"
                            required
                        ></b-form-textarea>
                    </b-form-group>

                    <b-button type="submit" variant="primary">{{ formOut.action }}</b-button>
                </b-form>
</template>

<script>
export default {
    props: ["formOut"],
    data() {
        return {
            img:null,
            show: true,
            images:[]
        };
    },
    methods: {
      onSubmit(event) {
        event.preventDefault()
        fetch(window.origin+'/'+this.formOut.uri,{
            method: this.formOut.method,
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
        // Reset our form values
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      },
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)return; 
            this.createImage(files);
        },
        createImage(file) {
            if(typeof FileReader==='undefined'){
                alert('Su navegador no admite carga de imágenes, actualice su navegador');
                return false;
                }
                var image = new Image();         

                var leng=file.length;
                for(var i=0;i<leng;i++){
                    var reader = new FileReader();
                    reader.readAsDataURL(file[i]); 
                    reader.onload =function(e){
                    this.formOut.form.img.push(e.target.result);                                    
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
