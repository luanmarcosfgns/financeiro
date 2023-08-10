import Helpers from "@/services/Helpers";

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
}