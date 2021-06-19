
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
                icon: 'list'
            },
        ],
    }

];

export default sideBarResponsibleLinks;
