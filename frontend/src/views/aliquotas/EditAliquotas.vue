<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Tabela de Preços</h5>
                    </div>
                    <div class="float-end">
                        <button-widget cor="azul" href="../index" tamanho="M">
                            Voltar
                        </button-widget>
                    </div>
                </div>
                <div class="col-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button @click="tabAliquotasOpen" class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Fomulário
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button @click="tabAliquotaListaOpen" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#enderecos-tab-pane" type="button" role="tab"
                                    aria-controls="enderecos-tab-pane" aria-selected="false">Itens
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div v-if="tabAliquotas" class="col-12">
                    <FormAliquotas></FormAliquotas>
                </div>
                <div v-if="tabAliquotaLista" class="col-12">
                    <IndexAliquotasItems></IndexAliquotasItems>
                </div>
                <div class="col-4">
                    <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
                </div>
            </div>
        </div>
    </layout-page>

</template>

<script>
import FormAliquotas from "@/views/aliquotas/FormAliquotas.vue";
import RequestHelper from "@/services/RequestHelper";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";
import IndexAliquotasItems from "@/views/aliquotas_items/IndexAliquotasItems.vue";

export default {
    name: "EditAliquotas",
    components: {IndexAliquotasItems, LayoutPage, ButtonWidget, FormAliquotas},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas/' + id, {});
            document.getElementById('nome').value = response.data.nome;
            document.getElementById('descritivo').value = response.data.descritivo;
            document.getElementById('ativo').value = response.data.ativo;

        },
        async sendForm() {
            let dataForm = {
                nome: document.getElementById('nome').value,
                descritivo: document.getElementById('descritivo').value,
                ativo: document.getElementById('ativo').value,


                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas/' + this.$route.params.id, dataForm);
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
        tabAliquotasOpen() {
            this.tabAliquotas = true;
            this.tabAliquotaLista = false;
            this.edit(this.$route.params.id)
        },
        tabAliquotaListaOpen() {
            this.tabAliquotas = false;
            this.tabAliquotaLista = true;
        },
    },
    created() {
        this.edit(this.$route.params.id)
    },
    data() {
        return {
            tabAliquotaLista: false,
            tabAliquotas: true,
            visible: false,
        }
    }
}
</script>

<style scoped>

</style>