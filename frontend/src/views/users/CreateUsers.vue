<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Adicionar Users</h5>
                    </div>
                    <div class="float-end">
                        <button-widget cor="azul" href="./index" tamanho="M">
                            Voltar
                        </button-widget>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <FormUsers></FormUsers>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>
</template>
<script>
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import FormUsers from "@/views/users/FormUsers.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreateUsers",
    components: {FormUsers, LayoutPage, ButtonWidget},
    methods: {
        async sendForm() {
            let dataForm = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,


            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/users', dataForm);
            if (response.data?.id) {
                location.href = './' + response.data.id + '/edit';
            } else {
                if (response.response.data?.message) {
                    toastr.error(response.response.data?.message);
                } else {
                    toastr.error('Houve um problema ao inserir');
                }

            }
        }
    }
}
</script>
<style scoped>
</style>