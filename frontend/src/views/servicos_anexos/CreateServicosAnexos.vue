<template>
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 ps-4 pt-3 ">
                <div class="float-start">
                    <h5>Adicionar Arquivos</h5>
                </div>
            </div>

        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <FormServicosAnexos></FormServicosAnexos>
            <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
        </div>
    </div>
</template>
<script>
import FormServicosAnexos from "@/views/servicos_anexos/FormServicosAnexos.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreateServicosAnexos",
    components: {FormServicosAnexos},
    methods: {
        async sendForm() {
            let dataForm = {
                anexo: document.getElementById('anexo').dataset.value,
                tipo: document.getElementById('tipo').value,
                servico_id: this.$route.params.id,


            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos_anexos', dataForm);
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