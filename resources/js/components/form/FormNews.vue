<template>
    <b-form @submit="onSubmit" v-if="show">
                <input type="hidden" name="_token" :value="csrf">
                    <b-form-file 
                        multiple
                        v-model="img"
                        :file-name-formatter="formatNames"
                        accept=".jpg, .png, .gif"
                    ></b-form-file>

                    <b-form-group id="input-group-2" label="Título:" label-for="input-2">
                        <b-form-input
                        id="input-2"
                        v-model="form.title"
                        placeholder="Título de la noticia"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-3" label="Subtítulo:" label-for="input-3">
                        <b-form-input
                        id="input-3"
                        v-model="form.subTitle"
                        placeholder="Subtítulo de la noticia"
                        required
                        ></b-form-input>
                    </b-form-group>

                    <b-form-group id="input-group-4" label="Contenido:" label-for="input-4">
                        <b-form-textarea
                            id="textarea-default"
                            v-model="form.content"
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
            form: {},
            img:null,
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
                text: 'Something went wrong!',
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
      },
      formatNames(files) {
          this.img.map(i=>{
              this.form.img.push(i.name);
          })
          return files.length === 1 ? files[0].name : `${files.length} files selected`
      }
    }
}
</script>

<style scoped>

</style>
