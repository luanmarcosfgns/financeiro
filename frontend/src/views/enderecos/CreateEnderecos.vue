<template>

    <div class="row">
        <div class="col-md-12 ps-4 pt-3 ">
            <div class="float-start">
                <h5>Adicionar Enderecos</h5>
            </div>

        </div>

    </div>
    <div class="row">
        <FormEnderecos></FormEnderecos>
        <div class="col-md-4">
            <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
        </div>

    </div>

</template>
<script>

import FormEnderecos from "@/views/enderecos/FormEnderecos.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreateEnderecos",
    components: { FormEnderecos},
    methods: {
        async sendForm() {
            let dataForm = {
                contato_id: document.getElementById('contato_id').value,
                endereco: document.getElementById('endereco').value,
                numero: document.getElementById('numero').value,
                bairro: document.getElementById('bairro').value,
                cidade: document.getElementById('cidade').value,
                cep: document.getElementById('cep').value,



            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/enderecos', dataForm);
            if (response.data?.id) {
                location.reload();
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