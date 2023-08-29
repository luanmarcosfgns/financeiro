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
        if(to.href=='/logout'){
            localStorage.setItem('HASH', undefined);
            location.href = '/login'
            return true;
        }
        return false;

    }

    finishLoading() {
        setTimeout(function(){
            document.getElementsByClassName('loading-page')[0].classList.add('d-none');
        },1000)
    }

   async uniqueConfiguration(to) {
        if(to.href=='/business/create'){
            let request = new RequestHelper();
            let resposeRequest = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/auth/me', {view:true});
            let business_id = await resposeRequest.data.business_id;
            let helper = new Helpers();
            if (!helper.empty(business_id)) {
                location.href = '/business/'+business_id+'/edit';
            }
        }
    }
}