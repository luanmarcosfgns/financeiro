<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Itens</h5>
                    </div>
                    <div class="float-end">
                        <button class="btn btn-primary" @click="goBack" tamanho="M">
                            Voltar
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <FormAliquotasItems></FormAliquotasItems>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>

</template>

<script>
import FormAliquotasItems from "@/views/aliquotas_items/FormAliquotasItems.vue";
import RequestHelper from "@/services/RequestHelper";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
    name: "EditAliquotasItems",
    components: {LayoutPage, FormAliquotasItems},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas_items/' + id, {});
            document.getElementById('nome').value = response.data.nome;
            this.aliquota_id = response.data.aliquota_id;
            document.getElementById('valor').value = response.data.valor;
            document.getElementById('porcentagem_comissao').value = response.data.porcentagem_comissao;
            document.getElementById('desconto_porcentagem').value = response.data.desconto_porcentagem;

        },
        async sendForm() {
            let dataForm = {
                nome: document.getElementById('nome').value,
                aliquota_id: this.aliquota_id,
                valor: document.getElementById('valor').value,
                porcentagem_comissao: document.getElementById('porcentagem_comissao').value,
                desconto_porcentagem: document.getElementById('desconto_porcentagem').value,
                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas_items/' + this.$route.params.id, dataForm);
            if (response.data?.id) {
                toastr.success('Salvo com sucesso')
            } else {
                if (response.response.data?.message) {
                    toastr.error(response.response.data?.message);
                } else {
                    toastr.error('Houve um problema ao inserir');
                }

            }
        },
        goBack(){
            history.back()
        }
    },
    created() {
        this.edit(this.$route.params.id)
    },
    data(){
        return {
            aliquota_id: null
        }
    }
}
</script>

<style scoped>

</style>