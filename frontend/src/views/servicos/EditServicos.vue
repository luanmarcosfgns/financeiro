<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Servicos</h5>
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
                            <button @click="tabServicosOpen" class="nav-link" :class="tabServicos?'active':''"
                                    data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Fomulário
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button @click="tabAnexosOpen" class="nav-link" :class="tabAnexos?'active':''"
                                    data-bs-toggle="tab"
                                    data-bs-target="#enderecos-tab-pane" type="button" role="tab"
                                    aria-controls="enderecos-tab-pane" aria-selected="false">Anexos
                            </button>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row" v-if="tabServicos">
                <FormServicos></FormServicos>
                <div class="col-md-4">
                    <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
                </div>

            </div>
            <div class="col-md-12" v-if="tabAnexos">
                <index-servicos-anexos></index-servicos-anexos>
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

export default {
    name: "EditServicos",
    components: {IndexServicosAnexos, LayoutPage, ButtonWidget, FormServicos},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos/' + id, {});
            document.getElementById('nome').value = response.data.nome;
            document.getElementById('descritivo').value = response.data.descritivo;
            document.getElementById('ecommerce').value = response.data.ecommerce;
            document.getElementById('preco').value = response.data.preco;
            document.getElementById('ativo').value = response.data.ativo;
            setTimeout(function () {
                document.getElementById('aliquota_id').value = response.data.aliquota_id;
                document.getElementById('categoria_id').value = response.data.categoria_id;
            }, 2000);

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
            this.edit(this.$route.params.id);
            localStorage.setItem('tabAnexos', false);
            localStorage.setItem('tabServicos', true);
        },
        tabAnexosOpen() {
            this.tabServicos = false;
            this.tabAnexos = true;
            localStorage.setItem('tabAnexos', true);
            localStorage.setItem('tabServicos', false);
        }
    },
    async mounted() {
        await this.edit(this.$route.params.id);
    },
    data() {
        return {
            tabServicos: false,
            tabAnexos: false,
        }
    }
    , created() {
        if (localStorage.getItem('tabAnexos') && localStorage.getItem('tabServicos')) {
            this.tabAnexos = localStorage.getItem('tabAnexos')
            this.tabServicos = localStorage.getItem('tabServicos')
            console.log(this.tabAnexos)
            console.log(this.tabServicos)
        }
    }

}
</script>

<style scoped>

</style>