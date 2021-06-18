
import trans from '../VueTranslation/Translation';
let sideBarLinks = [
    {
        name: "Dashboard",
        route: '/',
        child: []
    },
    {
        name: trans.translate('general.news.news'),
        child: [
            {
                name: "Crear Nueva",
                route: "/news/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.news.news'),
                route: "/news",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.categories.categories'),
        child: [
            {
                name: "Crear Nueva",
                route: "/categories/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.categories.categories'),
                route: "/categories",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.states.states'),
        child: [
            {
                name: "Crear Nueva",
                route: "/states/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.states.states'),
                route: "/states",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.areas.areas'),
        child: [
            {
                name: "Crear Nueva",
                route: "/areas/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.areas.areas'),
                route: "/areas",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.enrolments.enrolments'),
        child: [
            {
                name: "Crear Nueva",
                route: "/enrollment/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.enrolments.enrolments'),
                route: "/enrollment",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.incidences.incidences'),
        child: [
            /*{
                name: "Editar Incidencia",
                route: "/incidences/edit/:id",
                icon: 'plus'
            },*/
            {
                name: trans.translate('general.incidences.incidences'),
                route: "/incidences",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.roles.roles'),
         child: [
            {
                name: "Crear Nueva",
                route: "/roles/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.roles.roles'),
                route: "/roles",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.users.users'),
         child: [
            {
                name: "Crear Nuevo",
                route: "/users/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.users.users'),
                route: "/users",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.districts.districts'),
         child: [
            {
                name: "Crear Nuevo",
                route: "/district/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.districts.districts'),
                route: "/district",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.neighborhoods.neighborhoods'),
         child: [
            {
                name: "Crear Nuevo",
                route: "/neighborhood/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.neighborhoods.neighborhoods'),
                route: "/neighborhood",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.public_centers.public_centers'),
         child: [
            {
                name: "Crear Nuevo",
                route: "/public_center/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.public_centers.public_centers'),
                route: "/public_center",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.tags.tags'),
         child: [
            {
                name: "Crear Nuevo",
                route: "/tags/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.tags.tags'),
                route: "/tags",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.streets.streets'),
         child: [
            {
                name: "Crear Nuevo",
                route: "/street/new",
                icon: 'plus'
            },
            {
                name: trans.translate('general.streets.streets'),
                route: "/street",
                icon: 'list'
            },
        ],
    }

];

export default sideBarLinks;
