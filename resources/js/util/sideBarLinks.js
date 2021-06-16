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
        name: "Categorías",
        child: [
            {
                name: "Crear Nueva",
                route: "/categories/new",
                icon: 'plus'
            },
            {
                name: "Categorías",
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
        name: "Áreas",
        child: [
            {
                name: "Crear Nueva",
                route: "/areas/new",
                icon: 'plus'
            },
            {
                name: "Áreas",
                route: "/areas",
                icon: 'list'
            },
        ],
    },
    {
        name: "Matrículas",
        child: [
            {
                name: "Crear Nueva",
                route: "/enrollment/new",
                icon: 'plus'
            },
            {
                name: "Matrículas",
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
                name: "Crear Nuevo",
                route: "/users/new",
                icon: 'plus'
            },
            {
                name: "Usuarios",
                route: "/users",
                icon: 'list'
            },
        ],
    },
    {
        name: "Distritos",
         child: [
            {
                name: "Crear Nuevo",
                route: "/district/new",
                icon: 'plus'
            },
            {
                name: "Distritos",
                route: "/district",
                icon: 'list'
            },
        ],
    },
    {
        name: "Barrios",
         child: [
            {
                name: "Crear Nuevo",
                route: "/neighborhood/new",
                icon: 'plus'
            },
            {
                name: "Barrios",
                route: "/neighborhood",
                icon: 'list'
            },
        ],
    },
    {
        name: "Centros Públicos",
         child: [
            {
                name: "Crear Nuevo",
                route: "/public_center/new",
                icon: 'plus'
            },
            {
                name: "Centros Públicos",
                route: "/public_center",
                icon: 'list'
            },
        ],
    },
    {
        name: "Etiquetas",
         child: [
            {
                name: "Crear Nuevo",
                route: "/tags/new",
                icon: 'plus'
            },
            {
                name: "Etiquetas",
                route: "/tags",
                icon: 'list'
            },
        ],
    },
    {
        name: "Calles",
         child: [
            {
                name: "Crear Nuevo",
                route: "/street/new",
                icon: 'plus'
            },
            {
                name: "Calles",
                route: "/street",
                icon: 'list'
            },
        ],
    }

];

export default sideBarLinks;
