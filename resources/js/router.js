import	Vue	from	'vue';
import	VueRouter	from	'vue-router';

import Dashboard from './views/dashboard/Dashboard.vue';

import Incidences from './views/incidences/Incidences.vue';
import IncidenceEdit from './views/incidences/IncidenceEdit.vue';

import States from './views/states/States.vue';
import StatesNew from './views/states/StateNew.vue';
import StatesEdit from './views/states/StateEdit.vue';

import Users from './views/users/Users.vue';
import UserNew from './views/users/UserNew.vue';
import UserEdit from './views/users/UserEdit.vue';

import Roles from './views/roles/Roles.vue';
import RoleNew from './views/roles/RoleNew.vue';
import RoleEdit from './views/roles/RoleEdit.vue';

import Enrollment from './views/enrollment/Enrollment.vue';
import EnrollmentNew from './views/enrollment/EnrollmentNew.vue';
import EnrollmentEdit from './views/enrollment/EnrollmentEdit.vue';

import Areas from './views/areas/Areas.vue';
import AreaNew from './views/areas/AreaNew.vue';
import AreaEdit from './views/areas/AreaEdit.vue';

import Category from './views/category/Category.vue';
import CategoryEdit from './views/category/CategoryEdit.vue';
import CategoryNew from './views/category/CategoryNew.vue';

import District from './views/district/District.vue';
import DistrictEdit from './views/district/DistrictEdit.vue';
import DistrictNew from './views/district/DistrictNew.vue';

import Neighborhood from './views/neighborhood/Neighborhood.vue';
import NeighborhoodNew from './views/neighborhood/NeighborhoodNew.vue';
import NeighborhoodEdit from './views/neighborhood/NeighborhoodEdit.vue';

import NewsNew from './views/news/NewsNew.vue';
import News from './views/news/News.vue';
import NewsEdit from './views/news/NewsEdit.vue';

import PublicCenter from './views/publicCenter/PublicCenter.vue';
import PublicCenterNew from './views/publicCenter/PublicCenterNew.vue';
import PublicCenterEdit from './views/publicCenter/PublicCenterEdit.vue';

import Tags from './views/tags/Tags.vue';
import TagsNew from './views/tags/TagsNew.vue';
import TagsEdit from './views/tags/TagsEdit.vue';

import Street from './views/street/Street.vue';
import StreetNew from './views/street/StreetNew.vue';
import StreetEdit from './views/street/StreetEdit.vue';

import Profile from './views/profile/Profile.vue';
import WorkerAdd from './views/areas/WorkersAdd.vue';
import Historic from './views/historic/Historic.vue';
import HistoricShow from './views/historic/HistoricShow.vue';


Vue.use(VueRouter);
export	default	new	VueRouter({
    routes:	[
        {
            path: '/',
            name: "dashboard",
            component: Dashboard
        },
        {
            path:'/profile',
            name: "profile",
            component: Profile
        },
        {
            path:'/incidences',
            name: "incidences",
            component: Incidences
        },
        {
            path:'/incidences/edit/:id',
            name: "editIncidences",
            component: IncidenceEdit
        },
        {
            path:'/states',
            name: "states",
            component: States
        },
        {
            path:'/states/new',
            name: "newStates",
            component: StatesNew
        },
        {
            path:'/states/edit/:id',
            name: "editStates",
            component: StatesEdit
        },
        {
            path:'/users',
            name: "users",
            component: Users
        },
        {
            path:'/users/new',
            name: "newUser",
            component: UserNew,
        },
        {
            path:'/users/edit/:id',
            name: "editUser",
            component: UserEdit,
        },
        {
            path:'/roles',
            name: "roles",
            component: Roles
        },
        {
            path:'/roles/new',
            name: "newRole",
            component: RoleNew
        },
        {
            path:'/roles/edit/:id',
            name: "editRole",
            component: RoleEdit
        },
        {
            path:'/enrollment',
            name: "enrollment",
            component: Enrollment
        },
        {
            path:'/enrollment/new',
            name: "newEnrollment",
            component: EnrollmentNew
        },
        {
            path:'/enrollment/edit/:id',
            name: "editEnrollment",
            component: EnrollmentEdit
        },
        {
            path:'/areas',
            name: "areas",
            component: Areas
        },
        {
            path:'/areas/new',
            name: "newAreas",
            component: AreaNew
        },
        {
            path:'/areas/edit/:id',
            name: "editAreas",
            component: AreaEdit
        },
        {
            path:'/categories',
            name: "categories",
            component: Category
        },
        {
            path:'/categories/new',
            name: "newCategory",
            component: CategoryNew
        },
        {
            path:'/categories/edit/:id',
            name: "editCategory",
            component: CategoryEdit
        },
        {
            path:'/district',
            name: "district",
            component: District
        },
        {
            path:'/district/new',
            name: "newDistrict",
            component: DistrictNew
        },
        {
            path:'/district/edit/:id',
            name: "editDistrict",
            component: DistrictEdit
        },
        {
            path:'/neighborhood',
            name: "neighborhood",
            component: Neighborhood
        },
        {
            path:'/neighborhood/new',
            name: "newNeighborhood",
            component: NeighborhoodNew
        },
        {
            path:'/neighborhood/edit/:id',
            name: "editNeighborhood",
            component: NeighborhoodEdit
        },
        {
            path:'/news',
            name: "news",
            component: News
        },
        {
            path:'/news/new',
            name: "newNews",
            component: NewsNew
        },
        {
            path:'/news/edit/:id',
            name: "editNews",
            component: NewsEdit
        },
        {
            path:'/public_center',
            name: "public_center",
            component: PublicCenter
        },
        {
            path:'/public_center/new',
            name: "newPublicCenter",
            component: PublicCenterNew
        },
        {
            path:'/public_center/edit/:id',
            name: "editPublicCenter",
            component: PublicCenterEdit
        },
        {
            path:'/tags',
            name: "tags",
            component: Tags
        },
        {
            path:'/tags/new',
            name: "newTags",
            component: TagsNew
        },
        {
            path:'/tags/edit/:id',
            name: "editTags",
            component: TagsEdit
        },
        {
            path:'/street',
            name: "street",
            component: Street
        },
        {
            path:'/street/new',
            name: "newStreet",
            component: StreetNew
        },
        {
            path:'/street/edit/:id',
            name: "editStreet",
            component: StreetEdit
        },
        {
            path:'/workers/add/:id',
            name: "addWorker",
            component: WorkerAdd
        },
        {
            path:'/historic',
            name: "historic",
            component: Historic
        },
        {
            path:'/historic/:id',
            name: "showHistoric",
            component: HistoricShow
        },

    ]
});
