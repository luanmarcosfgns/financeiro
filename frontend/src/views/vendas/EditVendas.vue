<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Vendas</h5>
                    </div>
                    <div class="float-end">
                        <a class="btn btn-primary" href="/vendas/index">Voltar</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
                <FormVendas :vendaEdit="vendas" v-if="vendas!==null"></FormVendas>
            <div class="row">
                <div class="col-12 p-4">
                    <button class="btn btn-primary" type="button" @click="sendForm">Finalizar</button>
                </div>
            </div>
            </div>

    </layout-page>

</template>

<script>
import FormVendas from "@/views/vendas/FormVendas.vue";
import RequestHelper from "@/services/RequestHelper";

import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
    name: "EditVendas",
    components: {LayoutPage, FormVendas},
    data(){
        return {
            vendas:null
        }
    },
    methods: {
        async edit(id) {
            let request = new RequestHelper();
           this.vendas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas/' + id, {});


        },
        async sendForm() {
            let dataForm = {
                contato_id: document.getElementById('contato_id').value,
                descritivo: document.getElementById('descritivo').value,
                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas/' + this.$route.params.id, dataForm);
            if (response.data?.id) {
                toastr.success('Salvo com sucesso')
            } else {
                if (response.response.data?.message) {
                    toastr.error(response.response.data?.message);
                } else {
                    toastr.error('Houve um problema ao inserir');
                }

            }
        }
    },
    created() {
        this.edit(this.$route.params.id)
    }
}
</script>

<style scoped>

</style>