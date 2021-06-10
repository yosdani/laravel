import	Vue	from	'vue';
import	VueRouter	from	'vue-router';

import Dashboard from './views/dashboard/Dashboard.vue';
import Incidences from './views/incidences/Incidences.vue';
import States from './views/states/States.vue';
import Users from './views/users/Users.vue';
import UserNew from './views/users/UserNew.vue';
import Roles from './views/roles/Roles.vue';
import RoleNew from './views/roles/RoleNew.vue';

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
            path:'/states',
            name: "states",
            component: States
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
        }


    ]
});
