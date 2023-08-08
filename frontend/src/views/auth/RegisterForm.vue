<template>

    <div class=" p-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pt-5 pb-4">
                        <div>
                            <img width="150" src="@/assets/logo.png">
                            <h3>Fazer cadastro</h3>

                        </div>


                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="m-2">
                                Nome
                            </label>
                            <input type="text" class="form-control" id="name" placeholder="Digite o nome"
                                   aria-label="Username">
                        </div>

                        <div class="mb-3">
                            <label class="m-2">
                                Email
                            </label>
                            <input type="text" id="email" class="form-control" placeholder="Digite Email"
                                   aria-label="Username">
                        </div>
                        <div class="mb-3">
                            <label class="m-2">
                                Senha
                            </label>
                            <input type="password" class="form-control" id="password" placeholder="Digite a Senha"
                                   aria-label="Username">
                        </div>

                    </div>
                    <div class="card-footer pt-3 pb-5">
                        <div class="row">
                            <div class="col">
                                <button @click="registerForm" class="btn btn-lg btn-primary btn-loading">
                                    Registrar
                                </button>

                                <router-link to="login" class="btn btn-lg btn-primary btn-loading m-2 float-sm-end">
                                    Voltar
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

export default {
    name: "RegisterForm",
    methods: {
        registerForm: function () {

            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let name = document.getElementById('name').value;

            if (email.length < 5) {
                toastr.error("Email invalido");
                return false;
            }
            if (password.length < 6) {
                toastr.error("Senha muito pequena");
                return false;
            }
            if (name.length < 6) {
                toastr.error("Nome muito pequeno");
                return false;
            }

            let data = {
                email: email,
                password: password,
                name: name
            };

            axios.post(process.env.VUE_APP_API_HOST_NAME + '/api/auth/register', data)
                .then(function () {
                    toastr.info('Verifique a sua caixa de email para concluir o cadastro!');
                    document.getElementById('email').value = '';
                    document.getElementById('password').value = '';
                    document.getElementById('name').value = '';
                }).catch(function (error) {
                console.log(error);
                toastr.error(error.response.data.message);
            });

        }

    }
}
</script>

<style>
@import "toastr/build/toastr.css";

#app {
    background: #0d6efd;
}

html {
    background: #0d6efd;
}
</style>