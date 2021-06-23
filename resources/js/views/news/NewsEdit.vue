<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.edit')}} {{translate('general.news.new')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-news :formOut="formIn"></form-news>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormNews from '../../components/form/FormNews.vue';
import trans from '../../VueTranslation/Translation';
export default {
    data() {
    return {
      bItems: [
          {
              text: trans.translate('general.dashboard'),
              to: { name: 'dashboard' }
          },
          {
              text: trans.translate('general.news.news'),
              to: { name: 'news' }
          },
          {
              text: trans.translate('general.edit'),
              active: true
          }
      ],
      formIn: {
        formFrom: trans.translate('general.news.new'),
        action: trans.translate('general.save'),
          actionMessage: trans.translate('general.edited') + trans.translate('general.art_female'),
        form: {
            images: [],
            title: '',
            subTitle: '',
            content: '',
            category_id: '',
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
              this.formIn.uri = this.formIn.uri+'/'+response.data.id;
              this.formIn.form.title = response.data.title;
              this.formIn.form.subTitle = response.data.subTitle;
              this.formIn.form.content = response.data.content;
              this.formIn.form.images = response.data.images;
              this.formIn.form.category_id = response.data.category_id
          })
      }
  }
}
</script>

<style scoped>

</style>
