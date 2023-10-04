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


                </div>

            </div>
        </div>
        <div class="table-responsive">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Ações</th>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Vendedor</th>
                        <th>Status</th>
                        <th>Selecionado</th>
                        <th>Criado</th>

                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="row in rows" :key="row.id">
                        <td>
                            <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                                <button class="btn btn-danger btn-hover" @click="listPerguntas(row.id)">
                                          <span class="hover">
                                    Perguntas
                                          </span>
                                    <i class="bi bi-ui-checks"></i>
                                </button>
                                <button class="btn btn-danger btn-hover" @click="listServicos(row.id)">
                                          <span class="hover">
                                    Serviços
                                          </span>
                                    <i class="bi bi-briefcase-fill"></i>
                                </button>

                                <a class="btn btn-danger btn-hover" :href="'/vendas/'+row.id+'/edit'">
                                    <span class="hover">
                                        Editar Venda
                                    </span>
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </div>

                        </td>
                        <td>{{ row.id }}</td>
                        <td>{{ row.contato_nome }}</td>
                        <td>{{ row.user_name }}</td>
                        <td>{{ row.status }}</td>
                        <td>{{ row.selecionado }}</td>
                        <td>{{ row.created }}</td>

                    </tr>
                    <tr v-if="rows==null">
                        <td colspan="5" class="text-center"> Não há dados</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <ModalWidget id="list-servicos">
            <div class="row">
                <div class="col-12">
                    <h2>Serviços</h2>
                </div>
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>% Franquiadora</th>
                            <th>Comissão Vendedor</th>
                            <th>Corretora</th>
                            <th>Valor Prêmio</th>
                            <th>Desconto</th>
                        </tr>

                        </thead>
                        <tbody id="servicos">

                        </tbody>
                    </table>
                </div>
            </div>

        </ModalWidget>
        <ModalWidgetVue v-if="modalPerguntas"  id="list-perguntas">
            <div class="row">
                <div class="col-12">
                    <div  class="modal-content">
                        <span @click="noVisible" class="close">&times;</span>
                        <list-perguntas  :venda_id="venda_id" ></list-perguntas>
                    </div>
                </div>
            </div>


        </ModalWidgetVue>
    </layout-page>
</template>
<script>
import LayoutPage from "@/components/page/layoutPage.vue";

import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";
import ModalWidget from "@/components/widget/modalWidget.vue";
import ListPerguntas from "@/views/perguntas/ListPerguntas.vue";
import ModalWidgetVue from "@/components/widget/modalWidgetVue.vue";



export default {
    name: "IndexCotations",
    components: {ModalWidgetVue, ListPerguntas, ModalWidget, LayoutPage},
    data() {
        return {
            rows: null,
            search: null,
            perguntas: null,
            modalPerguntas:false,
            venda_id:null,
            modalAnexos:false
        }
    },
    methods: {
        noVisible(){
            this.modalPerguntas = false;
            this.modalAnexos = false;
        },
        async list() {


            let dataRequest = {
                tipo:'venda'
            };
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    search: this.search,
                    tipo:'venda'
                };
            }

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas', dataRequest);
            if (dataRow?.data?.data?.length > 0) {
                this.rows = dataRow.data.data;

            }


        },
        async listServicos(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas_servicos',{venda_id:id});
            if (!new Helpers().empty(dataRow?.data.data)) {
                let html='';

                for (const i in dataRow?.data.data) {
                    html += '<tr>' +
                        '<td>' + dataRow.data.data[i].servico_id + '</td>' +
                        '<td>' + dataRow.data.data[i].servico_nome + '</td>' +
                        '<td>' + dataRow.data.data[i].categoria_nome + '</td>' +
                        '</tr>';
                }
                document.getElementById('servicos').innerHTML = html;

                document.getElementById('list-servicos').classList.remove('d-none');

            } else {
                toastr.error('Houve um problema ao mostrar os serviços prestados');
            }
        },
        async listPerguntas(id) {
            this.venda_id = await id;
            this.modalPerguntas = true;

        },
        async gerarVenda(id) {
            let requestHelper = new RequestHelper();
            requestHelper.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas/'+id+'/tipoVendaTransform',{"_method": "PUT"});
            location.href = '/vendas/:id/edit'.replace(':id',id)
        },


    },
    created() {
        this.list();

    }
}

</script>

<style scoped>
@import "toastr/build/toastr.css";
@import "bootstrap-icons/font/bootstrap-icons.min.css";

button:hover {

}
</style>
<style>
:root {
    --display-hover: none;
}

span.hover {
    display: var(--display-hover) !important;

}

button.btn-hover:hover,a.btn-hover:hover {
    --display-hover: table;

}
</style>