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
import trans from "../../VueTranslation/Translation";
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
              to: { name: 'states' }
          },
          {
              text: trans.translate('general.add'),
              active: true
          }
      ],
      formIn: {
          formFrom: trans.translate('general.news.new'),
          action: trans.translate('general.save'),
          actionMessage: trans.translate('general.created') + trans.translate('general.art_female'),
          form: {
              images: [],
              title: '',
              subtitle: '',
              content: '',
              category_id: '',
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
