<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>

        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.add')}} {{translate('general.roles.role')}}</h3>
            </b-card-header>
            <b-card-body>
                <form-object :formOut="formIn"></form-object>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import FormObject from "../../components/form/FormObject.vue";
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
                    text: trans.translate('general.roles.roles'),
                    to: { name: 'roles' }
                },
                {
                    text: trans.translate('general.add'),
                    active: true
                }
            ],
            formIn: {
                formFrom:trans.translate('general.roles.role'),
                form: {
                    name: '',
                },
                action: trans.translate('general.save'),
                actionMessage: trans.translate('general.created') + trans.translate('general.art_male'),
                uri:'admin/roles',
                method: 'POST',
                route:'/states'
            }
        };
  },
  components:{
      FormObject
  }
}
</script>

<style scoped>

</style>
