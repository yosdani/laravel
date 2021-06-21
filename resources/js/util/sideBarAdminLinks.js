
import trans from '../VueTranslation/Translation';
let sideBarAdminLinks = [
    {
        name: "Dashboard",
        route: '/',
        child: []
    },
    {
        name: trans.translate('general.news.news'),
        child: [
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
                name: trans.translate('general.enrolments.enrolments'),
                route: "/enrollment",
                icon: 'list'
            },
        ],
    },
    {
        name: trans.translate('general.incidences.incidences'),
        child: [
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
                name: trans.translate('general.streets.streets'),
                route: "/street",
                icon: 'list'
            },
        ],
    }

];

export default sideBarAdminLinks;
