import	Vue	from	'vue';
import	VueRouter	from	'vue-router';

import Dashboard from './views/dashboard/Dashboard.vue';
import Incidences from './views/incidences/Incidences.vue';
import States from './views/states/States.vue';
import Users from './views/users/Users.vue';
import Roles from './views/roles/Roles.vue';

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
            path:'/roles',
            name: "roles",
            component: Roles
        }


    ]
});
