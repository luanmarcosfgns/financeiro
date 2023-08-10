import axios from "axios";
import toastr from "toastr/build/toastr.min";


export default class RequestHelper {
    constructor() {
    }

   async postAuth(url, data) {

        await axios.post(url, data, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("HASH")}`,
                Accept: 'application/json',
                "Content-Type": 'application/json'
            }
        })
            .then((response) => {
                window.axios = response;
            }).catch((error) => {
            if (error?.request.status == 401) {
                toastr.error("Login ou senha invalidos");
                window.axios = false;
            }
            if (error?.request.status == 403) {
                window.axios = false;
                localStorage.setItem('HASH', undefined);
                location.href = '/login'

            }
            toastr.error(error.response.data.message);
        });
        return  window.axios;

    }
}

