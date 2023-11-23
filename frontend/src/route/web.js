import {createRouter, createWebHistory} from "vue-router";

import RegisterForm from "@/views/auth/RegisterForm.vue";
import DashBoardPage from "@/views/pages/DashBoardPage.vue";

import LoginForm from "@/views/auth/LoginForm.vue";
import notFound from "@/views/errors/NotFound.vue";
import Middleware from "@/services/Middleware";
import CreateContas from "@/views/contas/CreateContas.vue";
import editContas from "@/views/contas/EditContas.vue";




const routes = [
    {
        path: '/login',
        name: 'LoginForm',
        component: LoginForm,
        meta: {
            auth: false
        }

    },
    {
        path: '/register',
        name: 'registerForm',
        component: RegisterForm,
        meta: {
            auth: false
        }
    },
    {
        path: '/contas/create',
        name: 'CreateContas',
        component: CreateContas
    },
    {
        path: '/contas/:id/edit',
        name: 'editContas',
        component: editContas
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

    }



})
router.afterEach((to) => {
    let middleware = new Middleware();
    middleware.setRegisterLastRouteBeforeLogin();
    middleware.userPermissions(to);
    middleware.finishLoading();
});
export default router;