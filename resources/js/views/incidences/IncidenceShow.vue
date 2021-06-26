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
                                @click="previewIncidence"
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
                                @click="nextIncidence"
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
                        <b-card
                            class="card-incidence"
                            no-body
                            style="max-width: 20rem;"
                        >
                            <b-card-header>
                                <b-carousel
                                    id="carousel-1"
                                    v-model="slide"
                                    :interval="4000"
                                    controls
                                    indicators
                                    background="#ababab"
                                    img-width="1024"
                                    img-height="480"
                                    style="text-shadow: 1px 1px 2px #333;"
                                    v-if="incidence"
                                >
                                    <b-carousel-slide v-for="(img,i) in incidence.images" :key="i" :img-src="img.image">
                                    </b-carousel-slide>
                                </b-carousel>
                            </b-card-header>
                            <template #header v-if="incidence">
                            <h4 class="mb-0">{{ incidence.title }}</h4>
                            </template>

                            <b-card-body>
                            <b-card-title v-if="incidence">{{ incidence.subTitle }}</b-card-title>
                            <b-card-sub-title class="mb-2" v-if="incidence">{{ incidence.subTitle }}</b-card-sub-title>
                            <b-card-text v-if="incidence">
                                {{ incidence.description }}
                            </b-card-text>
                            </b-card-body>

                            <b-list-group flush>
                                <b-list-group-item v-if="incidence">{{translate('general.areas.area')}}: {{ incidence.area?incidence.area.name:translate('general.not_element') }}</b-list-group-item>
                                <b-list-group-item v-if="incidence">{{translate('general.tags.tags')}}: {{ incidence.tag?incidence.tag.name:translate('general.not_element') }}</b-list-group-item>
                                <b-list-group-item v-if="incidence">{{translate('general.export_incidence.enrollment')}}: {{ incidence.enrolment?incidence.enrolment.name:translate('general.not_element') }}</b-list-group-item>
                                <b-list-group-item v-if="incidence">{{translate('general.states.state')}}: {{ incidence.state?incidence.state.name:translate('general.not_element') }}</b-list-group-item>
                                <b-list-group-item v-if="incidence">{{translate('general.export_incidence.public_center')}}: {{ incidence.public_center?incidence.public_center.name:translate('general.not_element') }}</b-list-group-item>
                                <b-list-group-item v-if="incidence">{{translate('general.export_incidence.street')}}: {{ incidence.street?incidence.street.street:translate('general.not_element') }}</b-list-group-item>
                                <b-list-group-item v-if="incidence">{{translate('general.export_incidence.neighborhood')}}: {{ incidence.neighborhood?incidence.neighborhood.name:translate('general.not_element') }}</b-list-group-item>
                            </b-list-group>
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
        getIncidence(){
            axios.get(window.origin+'/admin/incidence/datas/'+ this.$route.params.id)
            .then( response => {
                this.incidence = response.data.incidence;
                this.next = response.data.next;
                this.preview = response.data.preview;
            })
        },
        previewIncidence(){
            axios.get(window.origin+'/admin/incidence/datas/'+ this.preview)
            .then( response => {
                this.incidence = response.data.incidence;
                this.next = response.data.next;
                this.preview = response.data.preview;
            })
        },
        nextIncidence(){
            axios.get(window.origin+'/admin/incidence/datas/'+ this.next)
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
    left: 0;
    right: 0;
    margin-left: auto;
    margin-right: auto;
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