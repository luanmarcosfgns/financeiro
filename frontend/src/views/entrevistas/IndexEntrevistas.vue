<template>
    <div class="row">
        <div class="col-12 ps-4 pt-3 ">
            <div class="float-start">
                <h5> Entrevistas</h5>

            </div>


            <div class="float-end">
                <button type="button" class="btn btn-primary" @click="modalAdd">
                    Adicionar
                </button>
            </div>
        </div>

    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Ações</th>
                <th>#</th>
                <th>Ativo</th>
                <th>Nome</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in rows" :key="row.id">
                <td>
                    <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                        <router-link class="btn btn-danger" :to="'/entrevistas/'+row.id+'/edit'">
                            <i class="bi bi-pencil-square"></i>
                        </router-link>
                        <button class="btn btn-danger" @click="deleteRow(row.id)">
                            <i class="bi bi-trash2-fill"></i>
                        </button>
                    </div>

                </td>
                <td>{{ row.id }}</td>
                <td>{{ row.ativo }}</td>
                <td>{{ row.nome }}</td>



            </tr>
            <tr v-if="rows==null">
                <td colspan="4" class="text-center"> Não há dados</td>
            </tr>
            </tbody>
        </table>
    </div>
    <ModalWidget id="cadastrarEntrevista">
        <create-entrevistas></create-entrevistas>
    </ModalWidget>
</template>
<script>

import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";
import ModalWidget from "@/components/widget/modalWidget.vue";
import CreateEntrevistas from "@/views/entrevistas/CreateEntrevistas.vue";

export default {
    name: "IndexEntrevistas",
    components: {CreateEntrevistas, ModalWidget},
    data() {
        return {
            rows: null,
            search: null
        }
    },
    methods: {
        async list() {
            let dataRequest = {
                servico_id: this.$route.params.id
            };
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    servico_id: this.$route.params.id,
                    search: this.search
                };
            }

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/entrevistas', dataRequest);

            if (dataRow.data.data.length > 0) {
                this.rows = dataRow.data.data;

            }


        },
        async deleteRow(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/entrevistas/' + id);
            if (dataRow.data.success) {
                this.list();
                toastr.success('Apagado com sucesso');
            } else {
                toastr.error('Houve um problema ao apagar');
            }
        },
        modalAdd() {
            document.getElementById('cadastrarEntrevista').classList.remove('d-none')
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