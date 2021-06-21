
import trans from '../VueTranslation/Translation';
let sideBarResponsibleLinks = [
    {
        name: trans.translate('general.dashboard'),
        route: '/',
        child: []
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
        name: trans.translate('general.historic.historic'),
        route: "/historic",
        icon: 'clock',
        child: []
    },

];

export default sideBarResponsibleLinks;
