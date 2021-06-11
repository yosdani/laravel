import	Vue	from	'vue';
import	VueRouter	from	'vue-router';

import Dashboard from './views/dashboard/Dashboard.vue';
import Incidences from './views/incidences/Incidences.vue';
import IncidenceNew from './views/incidences/IncidenceNew.vue';
import States from './views/states/States.vue';
import StatesNew from './views/states/StateNew.vue';
import StatesEdit from './views/states/StateEdit.vue';
import Users from './views/users/Users.vue';
import UserNew from './views/users/UserNew.vue';
import Roles from './views/roles/Roles.vue';
import RoleNew from './views/roles/RoleNew.vue';
import RoleEdit from './views/roles/RoleEdit.vue';

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
            component: IncidenceNew
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
        }


    ]
});
