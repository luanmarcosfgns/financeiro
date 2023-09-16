<template>

    <div class="row">
        <div class="col-12">
            <div class="float-end">
                <button type="button" class="btn btn-primary" @click="modalAdd">
                    Adicionar
                </button>
            </div>
        </div>

    </div>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Porcentagem</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="row in rows" :key="row.id">
            <td>{{ row.id }}</td>
            <td>{{ row.nome }}</td>
            <td>{{ row.porcentagem.replaceAll('.',',') }}</td>
            <td>
                <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                    <router-link class="btn btn-danger" :to="'/aliquotasitems/'+row.id+'/edit'">
                        <i class="bi bi-pencil-square"></i>
                    </router-link>
                    <button class="btn btn-danger" @click="deleteRow(row.id)">
                        <i class="bi bi-trash2-fill"></i>
                    </button>
                </div>

            </td>
        </tr>
        <tr v-if="rows==null">
            <td colspan="3" class="text-center"> Não há dados</td>
        </tr>
        </tbody>
    </table>
    <ModalWidget id="cadastrar">
        <create-aliquotas-items></create-aliquotas-items>
    </ModalWidget>

</template>
<script>

import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";
import ModalWidget from "@/components/widget/modalWidget.vue";
import CreateAliquotasItems from "@/views/aliquotas_items/CreateAliquotasItems.vue";

export default {
    name: "IndexAliquotasItems",
    components: {CreateAliquotasItems, ModalWidget},
    data() {
        return {
            rows: null,
            search: null
        }
    },
    methods: {
        async list() {


            let dataRequest = {
                aliquota_id:this.$route.params.id
            };
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    search: this.search,
                    aliquota_id:this.$route.params.id
                };
            }

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas_items', dataRequest);

            if (dataRow.data.data.length > 0) {
                this.rows = dataRow.data.data;

            } else if (!helpers.empty(dataRow.response?.data)) {
                toastr.error('Houve um problema');
            }


        },
        async deleteRow(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas_items/' + id);
            if (dataRow.data.success) {
                this.list();
                toastr.success('Apagado com sucesso');
            } else {
                toastr.error('Houve um problema ao apagar');
            }
        },
        modalAdd(){
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