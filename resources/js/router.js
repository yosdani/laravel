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

Vue.use(VueRouter);
export	default	new	VueRouter({
    mode: 'history',
    routes:	[
        {
            path: '/',
            name: "dashboard",
            component: Dashboard
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
        }


    ]
});
