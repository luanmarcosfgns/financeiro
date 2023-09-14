<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Adicionar Contatos</h5>
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
                <FormContatos></FormContatos>
                <div class="col-4">
                    <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
                </div>
            </div>
        </div>
    </layout-page>
</template>
<script>
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import FormContatos from "@/views/contatos/FormContatos.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreateContatos",
    components: {FormContatos, LayoutPage, ButtonWidget},
    methods: {
        async sendForm() {
            let dataForm = {
                nome: document.getElementById('nome').value,
                razao: document.getElementById('razao').value,
                nascimento: document.getElementById('nascimento').value,
                estado_civil: document.getElementById('estado_civil').value,
                sexo: document.getElementById('sexo').value,
                rg_ie: document.getElementById('rg_ie').value,
                cnpj_cpf: document.getElementById('cnpj_cpf').value,
                telefone: document.getElementById('telefone').value,
                celular: document.getElementById('celular').value,
                email: document.getElementById('email').value,
                descritivo: document.getElementById('descritivo').value,
                ativo: document.getElementById('ativo').value,
                profissao: document.getElementById('profissao').value,


            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos', dataForm);
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