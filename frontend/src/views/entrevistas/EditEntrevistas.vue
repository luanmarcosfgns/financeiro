<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Entrevistas</h5>
                    </div>
                    <div class="float-end">
                        <button class="btn btn-primary" @click="goBack" tamanho="M">
                            Voltar
                        </button>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button id="tabFormularioOpenId" @click="tabFormularioOpen" class="nav-link active"
                                    data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Fomulário
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button id="tabPerguntasOpenId" @click="tabPerguntasOpen" class="nav-link"
                                    data-bs-toggle="tab"
                                    data-bs-target="#enderecos-tab-pane" type="button" role="tab"
                                    aria-controls="enderecos-tab-pane" aria-selected="false">Perguntas
                            </button>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row" :class="tabFormulario==false?'d-none':''">
                <FormEntrevistas></FormEntrevistas>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
            <div class="row" :class="tabPerguntas==false?'d-none':''">
                <index-perguntas></index-perguntas>
            </div>
        </div>
    </layout-page>

</template>

<script>
import FormEntrevistas from "@/views/entrevistas/FormEntrevistas.vue";
import RequestHelper from "@/services/RequestHelper";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";
import IndexPerguntas from "@/views/perguntas/IndexPerguntas.vue";

export default {
    name: "EditEntrevistas",
    components: {IndexPerguntas, LayoutPage, FormEntrevistas},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/entrevistas/' + id, {});
            document.getElementById('servicos_anexos_ativo').value = response.data.ativo;
            document.getElementById('servicos_anexos_descritivo').value = response.data.descritivo;
            document.getElementById('servicos_anexos_nome').value = response.data.nome;


        },
        async sendForm() {
            let dataForm = {
                ativo: document.getElementById('servicos_anexos_ativo').value,
                descritivo: document.getElementById('servicos_anexos_descritivo').value,
                nome: document.getElementById('servicos_anexos_nome').value,
                servico_id: this.$route.params.id,

                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/entrevistas/' + this.$route.params.id, dataForm);
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
        goBack() {
            history.back();
        },
        tabFormularioOpen() {
            this.tabFormulario = true;
            this.tabPerguntas = false;
        },
        tabPerguntasOpen() {
            this.tabFormulario = false;
            this.tabPerguntas = true;
        }
    },
    created() {
        this.edit(this.$route.params.id)
    },
    data() {
        return {
            tabFormulario: true,
            tabPerguntas: false
        }
    }
}
</script>

<style scoped>

</style>