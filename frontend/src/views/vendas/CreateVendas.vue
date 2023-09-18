<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Adicionar Vendas</h5>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-primary" href="./index">Voltar</a>
                    </div>
                </div>

            </div>
        </div>
        <FormVendas></FormVendas>
        <div class="row">
            <div class="col-12 p-4">
                <button class="btn btn-primary" type="button" @click="sendForm">Finalizar</button>
            </div>
        </div>

    </layout-page>
</template>
<script>

import LayoutPage from "@/components/page/layoutPage.vue";
import FormVendas from "@/views/vendas/FormVendas.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";
import Helpers from "@/services/Helpers";

export default {
    name: "CreateVendas",
    components: {FormVendas, LayoutPage},
    methods: {
        async sendForm() {
            let helper = new Helpers();
            let servicos = null;
            if (helper.isJsonString(localStorage.getItem('venda'))) {
                let venda = JSON.parse(localStorage.getItem('venda'));
                if (!helper.empty(venda?.servicos)) {
                    servicos = venda.servicos;
                    for (let i = 0; i < servicos.length; i++) {
                        servicos[i].desconto = document.getElementById('desconto[' + servicos[i].id + ']').value;
                        servicos[i].quantidade = document.getElementById('quantidade[' + servicos[i].id + ']').value;
                    }
                }
            }
            let dataForm = {
                contato_id: document.getElementById('contato_id').value,
                descritivo: document.getElementById('descritivo').value,
                tipo: document.getElementById('tipo').value,
                status: document.getElementById('status').value,
                servicos: servicos


            }
            if (!this.validateForm(dataForm)) {
                return false;
            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas', dataForm);
            if (response.data?.id) {
                this.resetForm();
                location.href = './' + response.data.id + '/edit';
            } else {
                if (response.response.data?.message) {
                    toastr.error(response.response.data?.message);
                } else {
                    toastr.error('Houve um problema ao inserir');
                }

            }
        },
        async validateForm(dataForm) {
            let helper = new Helpers();
            if (helper.empty(dataForm?.servicos)) {
                toastr.error('Não há nenhum produto adicionado');
                return false;
            }
            if (helper.empty(dataForm.tipo)) {
                toastr.error('Tipo inválido');
                return false;
            }
            if (helper.empty(dataForm.contato_id)) {
                toastr.error('Selecione um cliente');
                return false;
            }
            if (helper.empty(dataForm.status)) {
                toastr.error('Selecione um status');
                return false;
            }

            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos/list', {id: dataForm.contato_id});
            if (helper.empty(response.data.code)) {
                toastr.error('Selecione um cliente');
                return false;
            }

            return true;
        },
        resetForm() {
            document.getElementById('contato_id').value = '';
            document.getElementById('descritivo').value = '';
            document.getElementById('tipo').value = '';
            document.getElementById('status').value == '';
            localStorage.removeItem('venda')
        }
    },
    created() {
        this.resetForm();
        console.log(this.$emit)
    }
}
</script>
<style scoped>
</style>