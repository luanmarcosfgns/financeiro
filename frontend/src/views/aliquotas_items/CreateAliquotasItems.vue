<template>

    <div class="row">
        <div class="col-12 ps-4 pt-3 ">
            <div class="float-start">
                <h5>Adicionar</h5>
            </div>

        </div>

    </div>

    <div class="card-body">
        <div class="row">
            <FormAliquotasItems></FormAliquotasItems>
            <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
        </div>
    </div>
</template>
<script>
import FormAliquotasItems from "@/views/aliquotas_items/FormAliquotasItems.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreateAliquotasItems",
    components: {FormAliquotasItems},
    methods: {
        async sendForm() {
            let dataForm = {
                nome: document.getElementById('nome').value,
                aliquota_id: this.$route.params.id,
                descritivo: document.getElementById('descritivo').value,
                porcentagem: document.getElementById('porcentagem').value,


            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas_items', dataForm);
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