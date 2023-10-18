import Helpers from "@/services/Helpers";
import RequestHelper from "@/services/RequestHelper";

export default class Middleware {

    validateHash(to) {
        let helper = new Helpers();
        if (to.meta?.auth && helper.empty(localStorage.getItem("HASH"))) {
            location.href = "/login";
        }

        if (to.name == "LoginForm" && !helper.empty(localStorage.getItem("HASH"))) {
            location.href = '/painel'
        }
    }

    routeExists(to) {
        if (to.matched.length == 0) {
            location.href = '/404'
        }
    }

    logout(to) {
        if (to.href == '/logout') {
            localStorage.setItem('HASH', undefined);
            location.href = '/login'
            return true;
        }
        return false;

    }

    finishLoading() {
        setTimeout(function () {
            document.getElementsByClassName('loading-page')[0].classList.add('d-none');
        }, 1000)
    }

    async uniqueConfiguration(to) {
        if (to.href == '/business/create') {
            let request = new RequestHelper();
            let resposeRequest = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/auth/me', {view: true});
            let business_id = await resposeRequest.data.business_id;
            let helper = new Helpers();
            if (!helper.empty(business_id)) {
                location.href = '/business/' + business_id + '/edit';
            }
        }
    }

    setRegisterLastRouteBeforeLogin() {
        if (location.pathname !== "/login" && location.pathname !== "/logout" &&  location.pathname !== "/register") {
            localStorage.setItem('href', location.href);
            console.log(localStorage.getItem('href'))
        }
    }

    getRegisterLastRouteBeforeLogin() {
        return localStorage.getItem('href');
    }

    async userPermissions(to) {
       if(!to.meta.auth){
           return false;
       }

        if (to.href !== '/login' && (to.href.indexOf('/cotations/') == -1 || to.href == '/cotations/index')) {
            setTimeout(async () => {
                let request = new RequestHelper();
                let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/auth/me', {view: true});

                if (response?.data) {
                    let styleTag = document.createElement("style");
                    document.head.appendChild(styleTag);
                    if (response?.data?.type == 'admin') {



                        styleTag.innerHTML = '.admin_d_none {display:none;}';
                    }
                    if (response?.data?.type == 'revendedor') {
                        styleTag.innerHTML = '.revendedor_d_none {display:none;}';

                    }
                    if (response?.data?.type == 'vendedor') {
                        styleTag.innerHTML = '.vendedor_d_none {display:none;}';
                    }


                }
            }, 100)

        }


    }
}