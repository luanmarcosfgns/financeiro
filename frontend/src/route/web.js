import {createRouter, createWebHistory} from "vue-router";

import RegisterForm from "@/views/auth/RegisterForm.vue";
import IndexAliquotas from "@/views/aliquotas/IndexAliquotas.vue";
import IndexBusiness from "@/views/business/IndexBusiness.vue";
import IndexCategorias from "@/views/categorias/IndexCategorias.vue";
import IndexContatos from "@/views/contatos/IndexContatos.vue";
import DashBoardPage from "@/views/pages/DashBoardPage.vue";
import HomePage from "@/views/pages/HomePage.vue";
import IndexServicos from "@/views/servicos/IndexServicos.vue";
import IndexUsers from "@/views/users/IndexUsers.vue";
import IndexVendas from "@/views/vendas/IndexVendas.vue";
import LoginForm from "@/views/auth/LoginForm.vue";
import notFound from "@/views/errors/NotFound.vue";
import Middleware from "@/services/Middleware";
import CreateCategorias from "@/views/categorias/CreateCategorias.vue";
import EditCategorias from "@/views/categorias/EditCategorias.vue";
import CreateContatos from "@/views/contatos/CreateContatos.vue";
import EditContatos from "@/views/contatos/EditContatos.vue";
import createBusiness from "@/views/business/CreateBusiness.vue";
import EditBusiness from "@/views/business/EditBusiness.vue";
import EditEnderecos from "@/views/enderecos/EditEnderecos.vue";
import CreateServicos from "@/views/servicos/CreateServicos.vue";
import EditServicos from "@/views/servicos/EditServicos.vue";
import CreateAliquotas from "@/views/aliquotas/CreateAliquotas.vue";
import EditAliquotas from "@/views/aliquotas/EditAliquotas.vue";
import EditAliquotasItems from "@/views/aliquotas_items/EditAliquotasItems.vue";
import CreateUsers from "@/views/users/CreateUsers.vue";
import EditUsers from "@/views/users/EditUsers.vue";
import EditEntrevistas from "@/views/entrevistas/EditEntrevistas.vue";
import EditPerguntas from "@/views/perguntas/EditPerguntas.vue";
import CreateVendas from "@/views/vendas/CreateVendas.vue";
import EditVendas from "@/views/vendas/EditVendas.vue";
import FormCaptations from "@/views/cotacaos/FormCaptations.vue";


const routes = [
    {
        path: '/login',
        name: 'LoginForm',
        component: LoginForm,

    },
    {
        path: '/register',
        name: 'registerForm',
        component: RegisterForm
    },
    {
        path: '/aliquotas/index',
        name: 'indexAliquotas',
        component: IndexAliquotas,
        meta: {
            auth: true
        }
    },
    {
        path: '/aliquotas/create',
        name: 'createAliquotas',
        component: CreateAliquotas,
        meta: {
            auth: true
        }
    },
    {
        path: '/aliquotas/:id/edit',
        name: 'editAliquotas',
        component: EditAliquotas,
        meta: {
            auth: true
        }
    },
    {
        path: '/business/index',
        name: 'indexBusiness',
        component: IndexBusiness,
        meta: {
            auth: true
        }
    },
    {
        path: '/business/create',
        name: 'createBusiness',
        component: createBusiness,
        meta: {
            auth: true
        }
    },
    {
        path: '/business/:id/edit',
        name: 'editBusiness',
        component: EditBusiness,
        meta: {
            auth: true
        }
    },

    {
        path: '/categorias/index',
        name: 'indexCategorias',
        component: IndexCategorias,
        meta: {
            auth: true
        }
    },

    {
        path: '/categorias/create',
        name: 'createCategorias',
        component: CreateCategorias,
        meta: {
            auth: true
        }
    },
    {
        path: '/categorias/:id/edit',
        name: 'editCategorias',
        component: EditCategorias,
        meta: {
            auth: true
        }
    },

    {
        path: '/contatos/index',
        name: 'indexContatos',
        component: IndexContatos,
        meta: {
            auth: true
        }
    },
    {
        path: '/contatos/create',
        name: 'createContatos',
        component: CreateContatos,
        meta: {
            auth: true
        }
    },
    {
        path: '/contatos/:id/edit',
        name: 'editContatos',
        component: EditContatos,
        meta: {
            auth: true
        }
    },
    {
        path: '/enderecos/:id/edit',
        name: 'editEnderecos',
        component: EditEnderecos,
        meta: {
            auth: true
        }
    },
    {
        path: '/aliquotasitems/:id/edit',
        name: 'editAliquotasItems',
        component: EditAliquotasItems,
        meta: {
            auth: true
        }
    },

    {
        path: '/painel',
        name: 'painel',
        component: DashBoardPage,
        meta: {
            auth: true
        }
    },
    {
        path: '/home',
        name: 'home',
        component: HomePage
    },
    {
        path: '/servicos/index',
        name: 'indexServicos',
        component: IndexServicos,
        meta: {
            auth: true
        }
    },
    {
        path: '/servicos/create',
        name: 'createServicos',
        component: CreateServicos,
        meta: {
            auth: true
        }
    },
    {
        path: '/servicos/:id/edit',
        name: 'editServicos',
        component: EditServicos,
        meta: {
            auth: true
        }
    },
    {
        path: '/cotations/:id',
        name: 'FormCaptations',
        component: FormCaptations,
        meta: {
            auth: false
        }
    },


    {
        path: '/users/index',
        name: 'indexUsers',
        component: IndexUsers,
        meta: {
            auth: true
        }
    },
    {
        path: '/users/create',
        name: 'createUsers',
        component: CreateUsers,
        meta: {
            auth: true
        }
    },
    {
        path: '/users/:id/edit',
        name: 'editUsers',
        component: EditUsers,
        meta: {
            auth: true
        }
    },
    {
        path: '/entrevistas/:id/edit',
        name: 'editEntrevistas',
        component: EditEntrevistas,
        meta: {
            auth: true
        }
    },
    {
        path: '/perguntas/:id/edit',
        name: 'editPerguntas',
        component: EditPerguntas,
        meta: {
            auth: true
        }
    },

    {
        path: '/vendas/index',
        name: 'indexVendas',
        component: IndexVendas,
        meta: {
            auth: true
        }
    },
    {
        path: '/vendas/create',
        name: 'createVendas',
        component: CreateVendas,
        meta: {
            auth: true
        }
    },
    {
        path: '/vendas/:id/edit',
        name: 'editVendas',
        component: EditVendas,
        meta: {
            auth: true
        }
    },

    {
        path: '/404',
        component: notFound
    },
    {
        path: '/',
        redirect: '/login'
    }
];
const router = createRouter({history: createWebHistory(), routes});
router.beforeEach((to) => {
    let middleware = new Middleware();
    if (!middleware.logout(to)) {
        middleware.routeExists(to);
        middleware.validateHash(to);
        middleware.uniqueConfiguration(to);
    }
    middleware.finishLoading();


})

export default router;