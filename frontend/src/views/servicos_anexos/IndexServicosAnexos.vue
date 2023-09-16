<template>
        <div class="row">
            <div class="col-12 ps-4 pt-3 ">


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
                <th>Anexo</th>
                <th>Tipo</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row in rows" :key="row.id">
                <td>
                    <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                        <button class="btn btn-danger" @click="deleteRow(row.id)">
                            <i class="bi bi-trash2-fill"></i>
                        </button>
                    </div>

                </td>
                <td><img :src="row.anexo" alt="Anexo do Produto"  width="100"></td>
                <td>{{row.tipo}}</td>

            </tr>
            <tr v-if="rows==null">
                <td colspan="3" class="text-center"> Não há dados</td>
            </tr>
            </tbody>
        </table>
    </div>
    <ModalWidget id="cadastrar">
        <create-servicos-anexos>
        </create-servicos-anexos>
    </ModalWidget>
</template>
<script>
import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";
import ModalWidget from "@/components/widget/modalWidget.vue";
import CreateServicosAnexos from "@/views/servicos_anexos/CreateServicosAnexos.vue";

export default {
    name: "IndexServicosAnexos",
    components: {CreateServicosAnexos, ModalWidget},
    data() {
        return {
            rows: null,
            search: null
        }
    },
    methods: {
        async list() {
            let dataRequest = {
                servico_id:this.$route.params.id
            };
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    search: this.search,
                    servico_id:this.$route.params.id
                };
            }

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos_anexos', dataRequest);

            if (dataRow.data.data.length > 0) {
                this.rows = dataRow.data.data;

            } else  {
                toastr.info('Nenhum resultado encontrado');
            }


        },
        async deleteRow(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos_anexos/' + id);
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