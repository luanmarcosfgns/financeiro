<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5> Vendas</h5>
                    </div>
                    <div class="w-50">
                        <input id="search" class="form-control" @change="list()" placeholder="Digite sua pesquisa"
                               type="text" v-model="search">
                    </div>

                    <div class="float-end">
                        <button-widget cor="azul" href="./create" tamanho="M">
                            Adicionar
                        </button-widget>
                    </div>
                </div>

            </div>
        </div>
        <div class="table-responsive">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Valor Total</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="row in rows" :key="row.id">
                        <td>{{ row.id }}</td>
                        <td>{{ row.contato_id }}</td>
                        <td>{{ row.descritivo }}</td>
                        <td> R$ {{ row.valor_total.replace('.', ',') }}</td>
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
                        <td colspan="5" class="text-center"> Não há dados</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </layout-page>
</template>
<script>
import LayoutPage from "@/components/page/layoutPage.vue";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";

export default {
    name: "IndexVendas",
    components: {ButtonWidget, LayoutPage},
    data() {
        return {
            rows: null,
            search: null
        }
    },
    methods: {
        async list() {


            let dataRequest = {};
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    search: this.search
                };
            }

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas', dataRequest);

            if (dataRow.data.data.length > 0) {
                this.rows = dataRow.data.data;

            } else if (!helpers.empty(dataRow.response?.data)) {
                toastr.error('Houve um problema');
            }


        },
        async deleteRow(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas/' + id);
            if (dataRow.data.success) {
                this.list();
                toastr.success('Apagado com sucesso');
            } else {
                toastr.error('Houve um problema ao apagar');
            }
        }

    },
    created() {
        this.list();

    }
}

</script>

<style scoped>
@import "toastr/build/toastr.css";
@import "bootstrap-icons/font/bootstrap-icons.min.css";
</style>