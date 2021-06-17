<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.news.new')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-simple :formOut="formIn"></form-simple>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormSimple from '../../components/form/FormNews.vue';
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
              to: { name: 'states' }
          },
          {
              text: 'Adicionar',
              active: true
          }
      ],
      formIn: {
        formFrom:'Noticias',
        action: 'Adicionar',
        form: {
            img: [],
            title: '',
            subTitle: '',
            content: '',
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        uri:'admin/news',
        method: 'POST',
        route:'/news'
      }
    };
  },
  components:{
    FormSimple
  }
}
</script>

<style scoped>

</style>
