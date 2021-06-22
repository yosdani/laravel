
import trans from '../VueTranslation/Translation';
let sideBarAdminLinks = [
    {
        name: "Dashboard",
        route: '/',
        icon: 'clipboard-data',
        child: []
    },
    {
        name: trans.translate('general.news.news'),
        child: [
            {
                name: trans.translate('general.news.news'),
                route: "/news",
                icon: 'newspaper'
            },
            {
                name: trans.translate('general.categories.categories'),
                route: "/categories",
                icon: 'layout-text-window-reverse'
            },
        ],
        icon: 'newspaper'
    },
    {
        name: trans.translate('general.incidences.incidences'),
        child: [
            {
                name: trans.translate('general.incidences.incidences'),
                route: "/incidences",
                icon: 'exclamation-circle'
            },
            {
                name: trans.translate('general.states.states'),
                route: "/states",
                icon: 'toggles'
            },
            {
                name: trans.translate('general.tags.tags'),
                route: "/tags",
                icon: 'tag'
            },
            {
                name: trans.translate('general.enrolments.enrolments'),
                route: "/enrollment",
                icon: 'shield-exclamation'
            },
            {
                name: trans.translate('general.districts.districts'),
                route: "/district",
                icon: 'geo-alt-fill'
            },
            {
                name: trans.translate('general.streets.streets'),
                route: "/street",
                icon: 'signpost'
            },
            {
                name: trans.translate('general.neighborhoods.neighborhoods'),
                route: "/neighborhood",
                icon: 'signpost2'
            },
            {
                name: trans.translate('general.public_centers.public_centers'),
                route: "/public_center",
                icon: 'intersect'
            },
        ],
        icon: 'exclamation-circle'
    },
    {
        name: trans.translate('general.users.users'),
         child: [
            {
                name: trans.translate('general.users.users'),
                route: "/users",
                icon: 'people'
            },
             {
                 name: trans.translate('general.roles.roles'),
                 route: "/roles",
                 icon: 'people-fill'
             },
        ],
        icon: 'file-person'
    },
    {
        name: trans.translate('general.areas.areas'),
        route: "/areas",
        icon: 'exclude',
        child: []
    },
    {
        name: trans.translate('general.notifications.notifications'),
        route: '/notifications',
        child: [],
        icon: 'bell'
    },
    {
        name: trans.translate('general.historic.historic'),
        route: "/historic",
        icon: 'clock-history',
        child: []
    },

];

export default sideBarAdminLinks;
