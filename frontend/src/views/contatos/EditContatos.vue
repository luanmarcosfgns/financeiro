<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Contatos</h5>
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
                            <button @click="tabContatosOpen" class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#home-tab-pane" type="button" role="tab"
                                    aria-controls="home-tab-pane" aria-selected="true">Fomulário
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button @click="tabEnderecosOpen" class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#enderecos-tab-pane" type="button" role="tab"
                                    aria-controls="enderecos-tab-pane" aria-selected="false">Endereços
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row" v-if="tabContatos">
                <FormContatos></FormContatos>
                <div class="col-4">
                    <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
                </div>
            </div>
            <div class="col-12" v-if="tabEnderecos">
                <IndexEnderecos></IndexEnderecos>

            </div>


        </div>

    </layout-page>

</template>

<script>
import FormContatos from "@/views/contatos/FormContatos.vue";
import RequestHelper from "@/services/RequestHelper";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";
import IndexEnderecos from "@/views/enderecos/IndexEnderecos.vue";



export default {
    name: "EditContatos",
    components: {  IndexEnderecos, LayoutPage, ButtonWidget, FormContatos},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos/' + id, {});
            document.getElementById('nome').value = response.data.nome;
            document.getElementById('razao').value = response.data.razao;
            document.getElementById('nascimento').value = response.data.nascimento;
            document.getElementById('estado_civil').value = response.data.estado_civil;
            document.getElementById('sexo').value = response.data.sexo;
            document.getElementById('rg_ie').value = response.data.rg_ie;
            document.getElementById('cnpj_cpf').value = response.data.cnpj_cpf;
            document.getElementById('telefone').value = response.data.telefone;
            document.getElementById('celular').value = response.data.celular;
            document.getElementById('email').value = response.data.email;
            document.getElementById('descritivo').value = response.data.descritivo;
            document.getElementById('ativo').value = response.data.ativo;
            document.getElementById('profissao').value = response.data.profissao;


        },
        async sendForm() {
            let dataForm = {
                nome: document.getElementById('nome').value,
                razao: document.getElementById('razao').value,
                nascimento: document.getElementById('nascimento').value,
                estado_civil: document.getElementById('estado_civil').value,
                sexo: document.getElementById('sexo').value,
                rg_ie: document.getElementById('rg_ie').value,
                cnpj_cpf: document.getElementById('cnpj_cpf').value,
                telefone: document.getElementById('telefone').value,
                celular: document.getElementById('celular').value,
                email: document.getElementById('email').value,
                descritivo: document.getElementById('descritivo').value,
                ativo: document.getElementById('ativo').value,
                profissao: document.getElementById('profissao').value,


                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos/' + this.$route.params.id, dataForm);
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
        tabContatosOpen() {
            this.tabContatos = true;
            this.tabEnderecos = false;
            this.edit(this.$route.params.id)
        },
        tabEnderecosOpen() {
            this.tabContatos = false;
            this.tabEnderecos = true;
        },
        modalAdd() {
            document.getElementById('cadastrar').classList.remove('d-none')

        }
    },
    created() {
        this.edit(this.$route.params.id)
    },
    data() {
        return {
            tabContatos: true,
            tabEnderecos: false,
            visible: false,
        }
    }
}
</script>

<style scoped>

</style>