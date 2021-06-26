<template>
   <div>
        <b-breadcrumb :items="bItems"></b-breadcrumb>
        <b-card>
            <b-card-header class="border-0">
                <h3 class="mb-0 name-model">{{translate('general.incidences.incidences')}}</h3>
            </b-card-header>
            <b-card-body>
                <div>
                    <RouterLink v-if="preview" :to="route+'/'+preview" >
                            <a
                                v-if="preview"
                                class="float-left"
                                @click="getIncidence(preview)"
                            ><b-icon
                                    class="icon-incidence"
                                    icon="arrow-left-circle"
                                    aria-hidden="true"
                                ></b-icon>
                            </a>
                    </RouterLink>
                    <RouterLink v-if="next" :to="route+'/'+next" >
                            <a
                                v-if="next"
                                class="float-right"
                                @click="getIncidence(next)"
                            ><b-icon
                                    class="icon-incidence"
                                    icon="arrow-right-circle"
                                    aria-hidden="true"
                                ></b-icon>
                            </a>
                    </RouterLink>
                </div>
                <div>
                    <transition name="slide-fade">
                        <b-card class="card-incidence" no-body>
                            <b-card-header v-if="incidence.images.length > 0">
                                <b-carousel
                                    id="carousel-1"
                                    v-model="slide"
                                    :interval="4000"
                                    controls
                                    indicators
                                    background="#ababab"
                                    img-width="600px"
                                    style="text-shadow: 1px 1px 2px #333;">
                                    <b-carousel-slide v-for="(img,i) in incidence.images" :key="i" :img-src="img.url">
                                    </b-carousel-slide>
                                </b-carousel>
                            </b-card-header>
                            <template #header v-if="incidence">
                                <h4 class="mb-0">{{ incidence.title }}</h4>
                            </template>

                            <b-card-body>
                                <b-card-sub-title>
                                    {{translate('general.created_date')}}: {{ incidence.createdAt }} {{ translate('general.by') }} {{ incidence.user.name }} {{ incidence.user.lastName }}
                                    <span class="float-right"> {{translate('general.updated_date')}}: {{ incidence.updatedAt }}</span>
                                </b-card-sub-title>
                                <b-card-text class="mt-3 mb-3">
                                    {{ incidence.description }}
                                </b-card-text>
                            </b-card-body>
                            <b-container>
                                <b-row>
                                    <b-col md="6">
                                        <b-list-group-item><b>{{translate('general.areas.area')}}</b> : {{ incidence.area?incidence.area.name:'-'}}</b-list-group-item>
                                        <b-list-group-item><b>{{translate('general.states.state')}}</b> : {{ incidence.state?incidence.state.name:'-'}}</b-list-group-item>
                                        <b-list-group-item><b>{{translate('general.priorities.priority')}}</b> : {{ incidence.priority?incidence.priority.name:'-'}}</b-list-group-item>
                                        <b-list-group-item><b>{{translate('general.tags.tag')}}</b> : {{ incidence.tag?incidence.tag.name:'-'}}</b-list-group-item>
                                        <b-list-group-item><b>{{translate('general.incidences.worker')}}</b> : {{ incidence.assignedTo?incidence.assignedTo.name:'-'}}</b-list-group-item>
                                        <b-list-group-item><b>{{translate('general.incidences.address')}}</b> : {{ incidence.address?incidence.address:'-'}}</b-list-group-item>
                                        <b-list-group-item><b>{{translate('general.incidences.location')}}</b> : {{ incidence.location?incidence.location:'-'}}</b-list-group-item>
                                    </b-col>
                                    <b-col md="6">
                                        <b-list-group-item v-if="incidence"><b>{{translate('general.export_incidence.enrollment')}}</b> : {{ incidence.enrolment?incidence.enrolment.name:'-'}}</b-list-group-item>
                                        <b-list-group-item v-if="incidence"><b>{{translate('general.public_centers.public_center')}}</b> : {{ incidence.public_center?incidence.public_center.name:'-'}}</b-list-group-item>
                                        <b-list-group-item v-if="incidence"><b>{{translate('general.equipments.equipment')}}</b> : {{ incidence.equipment?incidence.equipment.name:'-'}}</b-list-group-item>
                                        <b-list-group-item v-if="incidence"><b>{{translate('general.districts.district')}}</b> : {{ incidence.district?incidence.district.name:'-'}}</b-list-group-item>
                                        <b-list-group-item v-if="incidence"><b>{{translate('general.streets.street')}}</b> : {{ incidence.street?incidence.street.street:'-'}}</b-list-group-item>
                                        <b-list-group-item v-if="incidence"><b>{{translate('general.neighborhoods.neighborhood')}}</b> : {{ incidence.neighborhood?incidence.neighborhood.name:'-'}}</b-list-group-item>
                                        <b-list-group-item v-if="incidence"><b>{{translate('general.incidences.deadline')}}</b> : {{ incidence.deadline?incidence.deadline:'-'}}</b-list-group-item>
                                    </b-col>
                                </b-row>
                            </b-container>
                            <b-container class="mt-3 mb-3">
                                <b-row>
                                    <b-col md="12">
                                        <b-list-group-item><b>{{translate('general.incidences.internalResponse')}}</b> : {{ incidence.internalResponse?incidence.internalResponse:'-'}}</b-list-group-item>
                                        <b-list-group-item><b>{{translate('general.incidences.responseForCitizen')}}</b> : {{ incidence.responseForCitizen?incidence.responseForCitizen:'-'}}</b-list-group-item>
                                    </b-col>
                                </b-row>
                            </b-container>

                        </b-card>
                    </transition>
                </div>
            </b-card-body>
        </b-card>

    </div>
</template>

<script>
export default {
    data() {
        return {
            bItems: [
                {
                    text: trans.translate('general.dashboard'),
                    to: { name: 'dashboard' }
                },
                {
                    text: trans.translate('general.incidences.incidences'),
                    to: { name: 'incidences' }
                },
                {
                    text: trans.translate('general.show'),
                    active: true
                }
            ],
            incidence: null,
            preview: null,
            next: null,
            slide: 0,
            route:'/incidences'
        }
    },
    mounted(){
        this.getIncidence();
    },
    methods: {
        getIncidence(id = null){
            if(!id){
                id = this.$route.params.id;
            }
            axios.get(window.origin+'/admin/incidence/'+ id)
            .then( response => {
                this.incidence = response.data.incidence;
                this.next = response.data.next;
                this.preview = response.data.preview;
            })
        }
    }
}
</script>
<style scoped>
.card-incidence{
    max-width: 50%!important;
    left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;
}
@media(max-width: 960px){
    .card-incidence {
        max-width: 90% !important;
    }
}
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active below version 2.1.8 */ {
  transform: translateX(10px);
  opacity: 0;
}
.icon-incidence{
    width: 30px;
    height: 30px;
    fill: #6C95C3;
}
</style>
