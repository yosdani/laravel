<template>
    <download-excel
        class="btn btn-primary"
        :data="json_data"
        name="Reporte_Incidencias.xls"
    >
       {{ translate('general.incidences.export')}}
    </download-excel>
</template>

<script>
import JsonExcel from "vue-json-excel";
import trans from "../../VueTranslation/Translation";
export default {
    data() {
        return {
            json_data:[],
        }
    },
    components:{
        'downloadExcel': JsonExcel
    },
    methods:{
        getData(){
            axios.get(window.origin+'/admin/export/incidence')
            .then(response => {
                response.data.incidences.map( incidence => {
                    this.json_data.push({
                        'Id': incidence.id,
                        'Título': incidence.title,
                        'Descripción' : incidence.description,
                        'Localizacion' : incidence.location,
                        'Direccion' : incidence.address,
                        'Calle' : incidence.street,
                        'Barrio': incidence.neighborhood,
                        'Distrito' : incidence.district,
                        'Etiquetas' : incidence.tags,
                        'Usuario' : incidence.user,
                        'Area' : incidence.area,
                        'Asignada a' : incidence.assignedTo,
                        'Estado' : incidence.state,
                        'Centro Publico' : incidence.public_center,
                        'Matricula' : incidence.enrollment,
                        "Creada" : incidence.created_at
                    })
                })
            })
        }
    }
}
</script>
