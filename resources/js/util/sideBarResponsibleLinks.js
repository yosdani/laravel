
import trans from '../VueTranslation/Translation';
let sideBarResponsibleLinks = [
    {
        name: "Dashboard",
        route: '/',
        child: []
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
