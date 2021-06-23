<template>
    <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>
        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0">{{translate('general.historic.historic')}}</h3>
            </b-card-header>
            <b-card-body v-if="historic">
                <p>{{ translate('general.incidences.incidence') }}: {{ historic.incidence_title }}</p>
                <p>{{ translate('general.incidences.created') }}: {{ historic.created_at }}</p>
                <p>{{ translate('general.users.user') }}: {{ historic.user.name }} {{ historic.user.lastName }}</p>
                <p>{{ translate('general.historic.field') }}:</p>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>{{ translate('general.historic.field') }}</th>
                            <th>{{ translate('general.historic.oldValue') }}</th>
                            <th>{{ translate('general.historic.value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                         <tr v-for="change in historic.data">
                             <td>{{ change.field }}</td>
                             <td>{{ change.oldValue }}</td>
                             <td>{{ change.value }}</td>
                         </tr>
                    </tbody>
                </table>
            </b-card-body>
        </b-card>
    </div>
</template>

<script>
import trans from '../../VueTranslation/Translation';
export default {
    data(){
        return {
            bItems: [
                {
                    text: trans.translate('general.dashboard'),
                    to: { name: 'dashboard' }
                },
                {
                    text: trans.translate('general.historic.historic'),
                    to: { name: 'historic' }
                },
                {
                    text: trans.translate('general.show'),
                    active: true
                }
            ],
            historic: null
        }
    },
    mounted() {
        this.getHistoricById( this.$route.params.id );
    },
    methods:{
        getHistoricById(id) {
            axios.get('/admin/historic/'+id)
                .then(response => {
                    this.historic = response.data.historic;
                    this.historic.data = JSON.parse(response.data.historic.data)
                })
        }
    }
}
</script>

<style scoped>

</style>
