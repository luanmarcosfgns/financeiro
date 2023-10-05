<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5> Contatos</h5>
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

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Ações</th>
                        <th>#</th>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Celular</th>
                        <th>Email</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="row in rows" :key="row.id">
                        <td>
                            <div class="btn-group btn-sm vendedor_d_none" role="group" aria-label="Basic example">
                                <router-link class="btn btn-danger" :to="'./'+row.id+'/edit'">
                                    <i class="bi bi-pencil-square"></i>
                                </router-link>
                                <button class="btn btn-danger  revendedor_d_none" @click="deleteRow(row.id)">
                                    <i class="bi bi-trash2-fill"></i>
                                </button>
                            </div>

                        </td>
                        <td>{{ row.id }}</td>
                        <td class="w-25">{{ row.nome }}</td>
                        <td>{{ row.cnpj_cpf }}</td>
                        <td>{{ row.celular }}</td>
                        <td>{{ row.email }}</td>

                    </tr>
                    <tr v-if="rows==null">
                        <td colspan="10" class="text-center"> Não há dados</td>
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
    name: "IndexContatos",
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

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos', dataRequest);

            if (dataRow.data.data.length > 0) {
                this.rows = dataRow.data.data;

            }


        },
        async deleteRow(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos/' + id);
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