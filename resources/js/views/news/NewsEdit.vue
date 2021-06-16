<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">Editar Noticia</h3>
            </b-card-header>
            <b-card-body>
                <form-news :formOut="formIn"></form-news>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormNews from '../../components/form/FormNews.vue';
export default {
    data() {
    return {
      bItems: [
          {
              text: 'Dashboard',
              to: { name: 'dashboard' }
          },
          {
              text: 'Noticias',
              to: { name: 'news' }
          },
          {
              text: 'Editar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Noticias',
        action: 'Editar',
        form: {
            img: [],
            title: '',
            subTitle: '',
            content: '',
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        uri:'admin/news',
        method: 'PUT',
        route:'/news'
      }
    };
  },
  components:{
    FormNews
  },
  mounted() {
      this.getNewById( this.$route.params.id );
  },
  methods:{
      getNewById(id) {
          axios.get('/admin/news/'+id)
          .then(response => {
              this.formIn.uri = this.formIn.uri+'/'+response.data[0].id;
              this.formIn.form.title = response.data[0].title;
              this.formIn.form.subTitle = response.data[0].subTitle;
              this.formIn.form.content = response.data[0].content;
              this.formIn.form.img = response.data[0].images;
          })
      }
  }
}
</script>

<style scoped>

</style>