<template>
    <div class="row">
        <div class="col-md-12">
            <div class="float-end">
                <button type="button" class="btn btn-primary" @click="modalAdd">
                    Adicionar
                </button>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 ps-4 pt-3 ">
            <div class="w-50">
                <input id="search" class="form-control" @change="list()" placeholder="Digite sua pesquisa"
                       type="text" v-model="search">
            </div>


        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>

            <th>Endereço</th>
            <th>Número</th>
            <th>Bairro</th>
            <th>Cidade</th>
            <th>CEP</th>

            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="row in rows" :key="row.id">
            <td>{{ row.id }}</td>
            <td>{{ row.endereco }}</td>
            <td>{{ row.numero }}</td>
            <td>{{ row.bairro }}</td>
            <td>{{ row.cidade }}</td>
            <td>{{ row.cep }}</td>


            <td>
                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                    <router-link class="btn btn-danger" :to="'./'+row.id+'/edit'">
                        <i class="bi bi-pencil-square"></i>
                    </router-link>
                    <button class="btn btn-danger" @click="deleteRow(row.id)">
                        <i class="bi bi-trash2-fill"></i>
                    </button>
                </div>

            </td>
        </tr>
        <tr v-if="rows==null">
            <td colspan="8" class="text-center"> Não há dados</td>
        </tr>
        </tbody>
    </table>

    <ModalWidget id="cadastrar">
        <create-enderecos></create-enderecos>
    </ModalWidget>

</template>
<script>


import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";
import CreateEnderecos from "@/views/enderecos/CreateEnderecos.vue";
import ModalWidget from "@/components/widget/modalWidget.vue";

export default {
    name: "IndexEnderecos",
    components: {ModalWidget, CreateEnderecos},
    data() {
        return {
            rows: null,
            search: null,
            visible: 'd-none'
        }
    },
    methods: {
        async list(id) {


            let dataRequest = {};
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    id: id,
                    search: this.search
                };
            } else {
                dataRequest = {
                    id: id,
                };
            }


            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/enderecos', dataRequest);

            if (dataRow.data.data.length > 0) {
                this.rows = dataRow.data.data;

            } else if (!helpers.empty(dataRow.response?.data)) {
                toastr.error('Houve um problema');
            }


        },
        async deleteRow(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/enderecos/' + id);
            if (dataRow.data.success) {
                toastr.success('Apagado com sucesso');
            } else {
                toastr.error('Houve um problema ao apagar');
            }
        },
        modalAdd() {
            document.getElementById('cadastrar').classList.remove('d-none')

        }

    },
    created() {

        this.list(this.$route.params.id);

    }
}

</script>

<style scoped>
@import "toastr/build/toastr.css";
@import "bootstrap-icons/font/bootstrap-icons.min.css";

</style>