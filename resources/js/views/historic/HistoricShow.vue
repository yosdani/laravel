<template>

</template>
<div>
<b-breadcrumb :items="bItems"></b-breadcrumb>
<b-card>
    <b-card-header class="border-0">
        <h3 class="mb-0">{{translate('general.historic.historic')}}</h3>
    </b-card-header>
    <b-card-body>

    </b-card-body>
</b-card>
</div>
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
        }
    },
    mounted() {
        this.getHistoricById( this.$route.params.id );
    },
    methods:{
        getHistoricById(id) {
            axios.get('/admin/historic/'+id)
                .then(response => {
                    this.historic = response.data;
                })
        }
    }
}
</script>

<style scoped>

</style>
