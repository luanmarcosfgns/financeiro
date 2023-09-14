<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Enderecos</h5>
                    </div>
                    <div class="float-end">
                        <button @click="goBack" class="btn btn-primary">
                            Voltar
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <FormEnderecos></FormEnderecos>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>

</template>

<script>
import FormEnderecos from "@/views/enderecos/FormEnderecos.vue";
import RequestHelper from "@/services/RequestHelper";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
    name: "EditEnderecos",
    components: {LayoutPage, FormEnderecos},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/enderecos/' + id, {});
            document.getElementById('contato_id').value = response.data.contato_id;
            document.getElementById('endereco').value = response.data.endereco;
            document.getElementById('numero').value = response.data.numero;
            document.getElementById('bairro').value = response.data.bairro;
            document.getElementById('cidade').value = response.data.cidade;
            document.getElementById('cep').value = response.data.cep;


        },
        async sendForm() {
            let dataForm = {
                contato_id: document.getElementById('contato_id').value,
                endereco: document.getElementById('endereco').value,
                numero: document.getElementById('numero').value,
                bairro: document.getElementById('bairro').value,
                cidade: document.getElementById('cidade').value,
                cep: document.getElementById('cep').value,
                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/enderecos/' + this.$route.params.id, dataForm);
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
            history.back();
        }
    },
    created() {
        this.edit(this.$route.params.id)
    }
}
</script>

<style scoped>

</style>