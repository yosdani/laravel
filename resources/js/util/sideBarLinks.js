let sideBarLinks = [
    {
        name: "Dashboard",
        route: '/',
        child: []
    },
    {
        name: "Noticias",
        child: [
            {
                name: "Crear Nueva",
                route: "/news/new",
                icon: 'plus'
            },
            {
                name: "Noticias",
                route: "/news",
                icon: 'list'
            },
        ],
    },
    {
        name: "Categorias",
        child: [
            {
                name: "Crear Nueva",
                route: "/categories/new",
                icon: 'plus'
            },
            {
                name: "Categorias",
                route: "/categories",
                icon: 'list'
            },
        ],
    },
    {
        name: "Estados",
        child: [
            {
                name: "Crear Nueva",
                route: "/states/new",
                icon: 'plus'
            },
            {
                name: "Estados",
                route: "/states",
                icon: 'list'
            },
        ],
    },
    {
        name: "Areas",
        child: [
            {
                name: "Crear Nueva",
                route: "/areas/new",
                icon: 'plus'
            },
            {
                name: "Areas",
                route: "/areas",
                icon: 'list'
            },
        ],
    },
    {
        name: "Matriculas",
        child: [
            {
                name: "Crear Nueva",
                route: "/enrollment/new",
                icon: 'plus'
            },
            {
                name: "Matriculas",
                route: "/enrollment",
                icon: 'list'
            },
        ],
    },
    {
        name: "Incidencias",
        child: [
            /*{
                name: "Editar Incidencia",
                route: "/incidences/edit/:id",
                icon: 'plus'
            },*/
            {
                name: "Incidencias",
                route: "/incidences",
                icon: 'list'
            },
        ],
    },
    {
        name: "Roles",
         child: [
            {
                name: "Crear Nueva",
                route: "/roles/new",
                icon: 'plus'
            },
            {
                name: "Roles",
                route: "/roles",
                icon: 'list'
            },
        ],
    },
    {
        name: "Usuarios",
         child: [
            {
                name: "Crear Nueva",
                route: "/users/new",
                icon: 'plus'
            },
            {
                name: "Usuarios",
                route: "/users",
                icon: 'list'
            },
        ],
    }

];

export default sideBarLinks;
