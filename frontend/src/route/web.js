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
        path: '/business/index',
        name: 'indexBusiness',
        component: IndexBusiness,
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
        path: '/contatos/index',
        name: 'indexContatos',
        component: IndexContatos,
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
        path: '/users/index',
        name: 'indexUsers',
        component: IndexUsers,
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
        path: '/404',
        component: notFound
    }
];
const router = createRouter({history: createWebHistory(), routes});
router.beforeEach((to) => {
    let middleware = new Middleware();
    if(!middleware.logout(to)){
        middleware.routeExists(to);
        middleware.validateHash(to);
    }
   middleware.finishLoading();


})

export default router;