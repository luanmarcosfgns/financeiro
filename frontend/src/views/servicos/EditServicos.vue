<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Serviços</h5>
                    </div>
                    <div class="float-end">
                        <button-widget cor="azul" href="../index" tamanho="M">
                            Voltar
                        </button-widget>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button id="tabServicosOpenId" @click="tabServicosOpen" class="nav-link active"
                                    data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Fomulário
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button id="tabAnexosOpenId" @click="tabAnexosOpen" class="nav-link"
                                    data-bs-toggle="tab"
                                    data-bs-target="#enderecos-tab-pane" type="button" role="tab"
                                    aria-controls="enderecos-tab-pane" aria-selected="false">Anexos
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button id="tabEntrevistaOpenId" @click="tabEntrevistasOpen" class="nav-link"
                                    data-bs-toggle="tab"
                                    data-bs-target="#enderecos-tab-pane" type="button" role="tab"
                                    aria-controls="enderecos-tab-pane" aria-selected="false">Entrevistas
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row" :class="tabServicos?'':'d-none'">
                <FormServicos></FormServicos>
                <div class="col-md-4">
                    <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
                </div>

            </div>
            <div class="col-md-12" :class="tabAnexos?'':'d-none'">
                <index-servicos-anexos></index-servicos-anexos>
            </div>
            <div class="col-md-12" :class="tabEntrevistas?'':'d-none'">
                <index-entrevistas></index-entrevistas>
            </div>
        </div>
    </layout-page>

</template>

<script>
import FormServicos from "@/views/servicos/FormServicos.vue";
import RequestHelper from "@/services/RequestHelper";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";
import IndexServicosAnexos from "@/views/servicos_anexos/IndexServicosAnexos.vue";
import IndexEntrevistas from "@/views/entrevistas/IndexEntrevistas.vue";

export default {
    name: "EditServicos",
    components: {IndexEntrevistas, IndexServicosAnexos, LayoutPage, ButtonWidget, FormServicos},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos/' + id, {});
            document.getElementById('nome').value = await response.data.nome;
            document.getElementById('descritivo').value = await response.data.descritivo;
            document.getElementById('ecommerce').value = await response.data.ecommerce;
            document.getElementById('preco').value = await response.data.preco;
            document.getElementById('ativo').value = await response.data.ativo;
            document.getElementById('aliquota_id').value = await response.data.aliquota_id;
            document.getElementById('categoria_id').value = await response.data.categoria_id;


        },
        async sendForm() {
            let dataForm = {
                nome: document.getElementById('nome').value,
                descritivo: document.getElementById('descritivo').value,
                ecommerce: document.getElementById('ecommerce').value,
                preco: document.getElementById('preco').value,
                aliquota_id: document.getElementById('aliquota_id').value,
                categoria_id: document.getElementById('categoria_id').value,
                ativo: document.getElementById('ativo').value,
                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos/' + this.$route.params.id, dataForm);
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
        tabServicosOpen() {
            this.tabServicos = true;
            this.tabAnexos = false;
            this.tabEntrevistas = false;
            localStorage.setItem('tabAnexos', 0);
            localStorage.setItem('tabServicos', 1);
            localStorage.setItem('tabEntrevistas', 0);
            console.log( localStorage.getItem('tabAnexos'),localStorage.getItem('tabServicos'),localStorage.getItem('tabEntrevistas'))
        },
        tabAnexosOpen() {
            this.tabServicos = false;
            this.tabAnexos = true;
            this.tabEntrevistas = false;

            localStorage.setItem('tabAnexos', 1);
            localStorage.setItem('tabServicos', 0);
            localStorage.setItem('tabEntrevistas', 0);
            console.log( localStorage.getItem('tabAnexos'),localStorage.getItem('tabServicos'),localStorage.getItem('tabEntrevistas'))
        },
        tabEntrevistasOpen() {
            this.tabServicos = false;
            this.tabAnexos = false;
            this.tabEntrevistas = true;
            localStorage.setItem('tabAnexos', 0);
            localStorage.setItem('tabServicos', 0);
            localStorage.setItem('tabEntrevistas', 1);
            console.log( localStorage.getItem('tabAnexos'),localStorage.getItem('tabServicos'),localStorage.getItem('tabEntrevistas'))
        }
    },
    async mounted() {

        await this.edit(this.$route.params.id);
        if (localStorage.getItem('tabAnexos') !== null && localStorage.getItem('tabServicos') !== null && localStorage.getItem('tabEntrevistas')) {
            if (localStorage.getItem('tabAnexos')==='1') {
                document.getElementById('tabAnexosOpenId').click();
            }
            if (localStorage.getItem('tabServicos')==='1') {
                document.getElementById('tabServicosOpenId').click();
            }
            if (localStorage.getItem('tabEntrevistas')==='1') {
                document.getElementById('tabEntrevistaOpenId').click();
            }
            console.log( localStorage.getItem('tabAnexos'),localStorage.getItem('tabServicos'),localStorage.getItem('tabEntrevistas'))
        }
    },
    data() {
        return {
            tabServicos: true,
            tabAnexos: false,
            tabEntrevistas: false,
        }
    }

}
</script>

<style scoped>

</style>