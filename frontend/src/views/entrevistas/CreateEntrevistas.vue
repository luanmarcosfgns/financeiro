<template>
    <div class="row">
        <div class="col-md-12 ps-4 pt-3 ">
            <div class="float-start">
                <h5>Adicionar Entrevistas</h5>
            </div>
            <div class="float-end">
                <button-widget cor="azul" href="./index" tamanho="M">
                    Voltar
                </button-widget>
            </div>
        </div>

    </div>

    <div class="row">
        <FormEntrevistas></FormEntrevistas>
        <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
    </div>
</template>
<script>
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import FormEntrevistas from "@/views/entrevistas/FormEntrevistas.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreateEntrevistas",
    components: {FormEntrevistas, ButtonWidget},
    methods: {
        async sendForm() {
            let dataForm = {
                ativo: document.getElementById('servicos_anexos_ativo').value,
                descritivo: document.getElementById('servicos_anexos_descritivo').value,
                nome: document.getElementById('servicos_anexos_nome').value,
                servico_id:this.$route.params.id


            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/entrevistas', dataForm);
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