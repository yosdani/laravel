<template>
    <div>
        <b-row class="mb-3">
            <b-col lg="3" class="my-1">
                <b-form-group
                    class="mb-0"
                >
                    <b-input-group size="sm">
                        <b-form-input
                            id="filter-input"
                            v-model="filter"
                            type="search"
                            :placeholder="translate('general.search')"
                        ></b-form-input>

                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>

            <b-col lg="6" class="my-1">
                <b-form-group
                    v-model="sortDirection"
                    :label="translate('general.filter_by')"
                    description=""
                    label-cols-sm="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                    v-slot="{ ariaDescribedby }"
                >
                    <b-form-checkbox-group
                        v-model="filterOn"
                        :aria-describedby="ariaDescribedby"
                        class="mt-1"
                    >
                        <b-form-checkbox v-show="items" v-for="field in filterField" :key="field.key" @change="getFilterOn($event)" :value="field.key">{{field.label}}</b-form-checkbox>
                    </b-form-checkbox-group>
                </b-form-group>
            </b-col>
            <b-col sm="6" md="3" class="my-1">
                <b-form-group
                    :label="translate('pagination.per_page')"
                    label-for="per-page-select"
                    label-cols-sm="6"
                    label-cols-md="4"
                    label-cols-lg="3"
                    label-align-sm="right"
                    label-size="sm"
                    class="mb-0"
                >
                    <b-form-select
                        id="per-page-select"
                        v-model="perPage"
                        :options="pageOptions"
                        size="sm"
                    ></b-form-select>
                </b-form-group>
            </b-col>

        </b-row>
        <!-- Main table element -->
        <b-table
            :items="items"
            :fields="items?fields:[]"
            :current-page="currentPage"
            :per-page="perPage"
            :filter="filter"
            :filter-included-fields="filterOn"
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            :sort-direction="sortDirection"
            stacked="md"
            :striped="true"
            :hover="true"
            :responsive="true"
            :bordered="true"
            :show-empty="false"
            @filtered="onFiltered"
        >
            <template #table-busy>
                <div class="text-center text-danger my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Cargando...</strong>
                </div>
            </template>
            <template #cell(actions)="row">
                <b-form-row>
                    <b-col v-if="route==='/areas'">
                        <RouterLink :to="'/workers/add/'+row.item.id">
                            <b-button variant="primary" size="sm"><b-icon icon="plus-circle" aria-hidden="true"></b-icon> {{ translate('general.areas.worker') }}
                            </b-button>
                        </RouterLink>
                    </b-col>
                    <b-col  v-if="allowEdit">
                        <RouterLink :to="route+'/edit/'+row.item.id"  v-if="allowEdit">
                            <b-button variant="success" size="sm">
                                <b-icon icon="pencil" aria-hidden="true"></b-icon>
                                {{ translate('general.edit') }}
                            </b-button>
                        </RouterLink>
                    </b-col>
                    <b-col  v-if="allowDelete">
                        <b-button variant="danger" type="submit" size="sm" @click="deleteElement(row.item,$event)" v-if="allowDelete">
                            <b-icon icon="trash-fill" aria-hidden="true"></b-icon>
                            {{ translate('general.delete') }}
                        </b-button>
                    </b-col>
                    <b-col v-if="allowShow">
                        <RouterLink :to="route+'/'+row.item.id" >
                            <b-button variant="info" size="sm"><b-icon icon="eye" aria-hidden="true"></b-icon>
                                {{ translate('general.show') }}
                            </b-button>
                        </RouterLink>
                    </b-col>
                </b-form-row>
            </template>
            <template #row-details="row">
                <b-card>
                    <ul>
                        <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                    </ul>
                </b-card>
            </template>
        </b-table>
        <div class="row">
            <b-col sm="6" md="6" lg="4" class="my-1 text-right">
                <b-pagination-nav
                    :link-gen="linkGen"
                    :number-of-pages="lastPage"
                    :base-url="route"
                    use-router>
                </b-pagination-nav>
            </b-col>
        </div>
    </div>
</template>
<script>
import EventBus from '../event-bus';
export default {
    props:['items','fields', 'current','total','offset','actions','route','allowEdit', 'allowDelete', 'allowShow','lastPage'],
    data() {
        return {
            totalRows: 1,
            currentPage: 1,
            perPage: 15,
            pageOptions: [10, 15, 20, 50, 100],
            sortBy: '',
            sortDesc: false,
            sortDirection: 'asc',
            filter: null,
            filterOn: [],
            uri:'',
            filterField: []
        }
    },
    created() {
        this.uri = window.origin;
        this.fields.map(field => {
            if( field.key !== 'actions')
                this.filterField.push(field);
        })
        this.totalRows = this.total;
        this.currentPage = this.current;
    },
    components:{
    },
    mounted(){
        this.totalRows  =this.total;
        this.currentPage = this.current;
        this.perPage = this.offsets;
    },
    watch:{
        'total': function (val){
            this.totalRows = val;
        },
        'current': function (val){
            this.currentPage = val;
        },
        'offset': function (val){
            this.perPage = val;
        }
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.fields
                .filter(f => f.sortable)
                .map(f => {
                    return { text: f.label, value: f.key }
                })
        }
    },
    methods: {
        linkGen(pageNum) {
            return pageNum === 1 ? '?' : `?page=${pageNum}`;
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },
        getFilterOn(event){
            this.filterOn = event;
        },
        deleteElement(item,event){
            event.preventDefault()
            this.$swal.fire({
                title: trans.translate('general.are_you_sure'),
                text: trans.translate('general.not_reversible'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: trans.translate('general.yes')
            }).then((result) => {
                if(result.isConfirmed) {
                    axios.delete(window.origin+'/'+this.actions+'/'+item.id)
                        .then(result => {
                            EventBus.$emit('DELETED_ITEM_'+this.route);
                            this.$swal.fire({
                                icon: 'success',
                                title: trans.translate('general.deleted'),
                                text: ''
                            })
                        })
                        .catch(error =>{
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: error,
                            })
                        })
                }
            })
        },
    }
}
</script>
<style>
#per-page-select{
    width: 100px;
}
.action-column{
    width: 250px;
}
.action-column-large{
    width: 400px;
}
#filter-input{
    width: 100px;
}
</style>
