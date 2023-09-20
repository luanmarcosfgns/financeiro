<template>

    <div class="content-wrapper p-5">
        <div class="row justify-content-center">
            <div class="col-6" style="max-width: 360px; min-width: 280px">
                <div class="card">
                    <div class="card-header pt-5 pb-4">
                        <div>
                            <img width="150" src="@/assets/logo.png">
                            <h3>Fazer Login</h3>
                            <label>Proseguir para {{ appName }}</label>
                        </div>


                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="email" placeholder="Digite seu Usuário"
                            >
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" placeholder="Digite seu Senha"
                                   id="password">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="save">
                            <label class="form-check-label" for="flexCheckDefault">
                                Salvar a senha?
                            </label>
                        </div>
                    </div>
                    <div class="card-footer pt-3 pb-5">
                        <div class="row">
                            <div class="col-12 d-grid gap-2">
                                <button @click="login" class="btn btn-lg btn-primary btn-loading">
                                    Entrar
                                </button>
                                <router-link to="register" class="btn btn-lg btn-danger btn-loading">
                                    Criar Usuário
                                </router-link>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>


import axios from "axios";
import toastr from "toastr/build/toastr.min";
import registerForm from "@/views/auth/RegisterForm.vue";
import Middleware from "@/services/Middleware";
import Helpers from "@/services/Helpers";


export default {
    name: "LoginForm",
    computed: {
        registerForm() {
            return registerForm
        }
    },
    data() {
        return {
            appName: process.env.VUE_APP_APPLICATION_NAME
        }
    }, methods: {
        login: function () {
            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let save = document.getElementById('save').value;

            let data = {
                email: email,
                password: password,
                save: save
            };
            axios.post(process.env.VUE_APP_API_HOST_NAME + '/api/auth/login', data,{
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("HASH")}`,
                    Accept: 'application/json',
                    "Content-Type": 'application/json'
                }
            })
                .then(function (response) {
                    localStorage.setItem('HASH',response.data.data.token);
                    let url = new Middleware().getRegisterLastRouteBeforeLogin()
                    if(new Helpers().empty(url)){
                        url = '/painel'
                    }
                    location.href = url;

                }).catch(function (error) {
              if(error.request.status==401){
                  toastr.error("Login ou senha invalidos");
                  return false;
              }
                console.log(error)
                toastr.error(error.response.data.message);
            });
        }
    }
}
</script>

<style>
body {
    background: #3baaa1;
}

@import "toastr/build/toastr.css";

</style>