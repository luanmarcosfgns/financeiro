<template>


    <div class="row">
        <div class="col-12 ps-4 pt-3 ">
            <div class="float-start">
                <h5> Perguntas</h5>

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
            <div class="w-100">
                <input id="search" class="form-control" @change="list()" placeholder="Digite sua pesquisa"
                       type="text" v-model="search">
            </div>
        </tr>
        <tr>
            <th>Ações</th>
            <th>#</th>
            <th>Enunciado</th>
            <th>Ordem</th>
            <th>Tipo de Resposta</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="row in rows" :key="row.id">
            <td>
                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                    <router-link class="btn btn-danger" :to="'/perguntas/'+row.id+'/edit'">
                        <i class="bi bi-pencil-square"></i>
                    </router-link>
                    <button class="btn btn-danger" @click="deleteRow(row.id)">
                        <i class="bi bi-trash2-fill"></i>
                    </button>
                </div>

            </td>
            <td>{{ row.id }}</td>
            <td>{{ row.enunciado }}</td>
            <td>{{ row.ordem }}</td>
            <td>{{ row.tipo_resposta }}</td>


        </tr>
        <tr v-if="rows==null">
            <td colspan="5" class="text-center"> Não há dados</td>
        </tr>
        </tbody>
    </table>
    </div>
    <ModalWidget id="cadastrar">
        <create-perguntas>
        </create-perguntas>
    </ModalWidget>

</template>
<script>

import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";
import ModalWidget from "@/components/widget/modalWidget.vue";
import CreatePerguntas from "@/views/perguntas/CreatePerguntas.vue";

export default {
    name: "IndexPerguntas",
    components: {CreatePerguntas, ModalWidget},
    data() {
        return {
            rows: null,
            search: null
        }
    },
    methods: {
        async list() {


            let dataRequest = {
                entrevista_id:this.$route.params.id,

            };
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    search: this.search,
                    entrevista_id:this.$route.params.id
                };
            }

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas', dataRequest);

            if (dataRow.data.data.length > 0) {
                this.rows = dataRow.data.data;

            } else  {
                toastr.info('Nenhum resultado encontrado');
            }


        },
        async deleteRow(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas/' + id);
            if (dataRow.data.success) {
                this.list();
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
        this.list();

    }
}

</script>

<style scoped>
@import "toastr/build/toastr.css";
@import "bootstrap-icons/font/bootstrap-icons.min.css";
</style>