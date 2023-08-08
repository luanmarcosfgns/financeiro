import {createRouter, createWebHistory} from "vue-router";

import RegisterForm from "@/views/auth/RegisterForm.vue";
import FormAliquotas from "@/views/aliquotas/FormAliquotas.vue";
import IndexAliquotas from "@/views/aliquotas/IndexAliquotas.vue";
import IndexBusiness from "@/views/business/IndexBusiness.vue";
import FormBusiness from "@/views/business/FormBusiness.vue";
import IndexCategorias from "@/views/categorias/IndexCategorias.vue";
import FormCategorias from "@/views/categorias/FormCategorias.vue";
import IndexContatos from "@/views/contatos/IndexContatos.vue";
import FormContatos from "@/views/contatos/FormContatos.vue";
import DashBoardPage from "@/views/pages/DashBoardPage.vue";
import HomePage from "@/views/pages/HomePage.vue";
import IndexServicos from "@/views/servicos/IndexServicos.vue";
import FormServicos from "@/views/servicos/FormServicos.vue";
import IndexSessions from "@/views/sessions/IndexSessions.vue";
import FormSessions from "@/views/sessions/FormSessions.vue";
import IndexUsers from "@/views/users/IndexUsers.vue";
import FormUsers from "@/views/users/FormUsers.vue";
import IndexVendas from "@/views/vendas/IndexVendas.vue";
import FormVendas from "@/views/vendas/FormVendas.vue";
import LoginForm from "@/views/auth/LoginForm.vue";
import notFound from "@/views/errors/NotFound.vue";


const routes = [
    {
        path: '/login',
        name: 'LoginForm',
        component: LoginForm
    },
    {
        path: '/register',
        name: 'registerForm',
        component: RegisterForm
    },
    {
        path: '/aliquotas/index',
        name: 'indexAliquotas',
        component: IndexAliquotas
    },
    {
        path: '/aliquotas/form',
        name: 'formAliquotas',
        component: FormAliquotas
    },
    {
        path: '/business/index',
        name: 'indexBusiness',
        component: IndexBusiness
    },
    {
        path: '/business/form',
        name: 'formBusiness',
        component: FormBusiness
    },
    {
        path: '/categorias/index',
        name: 'indexCategorias',
        component: IndexCategorias
    },
    {
        path: '/categorias/form',
        name: 'formCategorias',
        component: FormCategorias
    },
    {
        path: '/contatos/index',
        name: 'indexContatos',
        component: IndexContatos
    },
    {
        path: '/contatos/form',
        name: 'formCategorias',
        component: FormContatos
    },
    {
        path: '/painel',
        name: 'painel',
        component: DashBoardPage
    },
    {
        path: '/home',
        name: 'home',
        component: HomePage
    },
    {
        path: '/servicos/index',
        name: 'indexServicos',
        component: IndexServicos
    },
    {
        path: '/servicos/form',
        name: 'formServicos',
        component: FormServicos
    },

    {
        path: '/sessions/index',
        name: 'indexSessions',
        component: IndexSessions
    },
    {
        path: '/sessions/form',
        name: 'formSessions',
        component: FormSessions
    },
    {
        path: '/users/index',
        name: 'indexUsers',
        component: IndexUsers
    },
    {
        path: '/users/form',
        name: 'formUsers',
        component: FormUsers
    },
    {
        path: '/vendas/index',
        name: 'indexVendas',
        component: IndexVendas
    },
    {
        path: '/vendas/form',
        name: 'formVendas',
        component: FormVendas
    },
    {
        path: '/404',
        component: notFound
    }
];
const router = createRouter({history: createWebHistory(), routes});

export default router;