<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Perguntas</h5>
                    </div>
                    <div class="float-end">
                        <button class="btn btn-primary" @click="goBack" >
                            Voltar
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <FormPerguntas></FormPerguntas>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>

</template>

<script>
import FormPerguntas from "@/views/perguntas/FormPerguntas.vue";
import RequestHelper from "@/services/RequestHelper";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
    name: "EditPerguntas",
    components: {LayoutPage, FormPerguntas},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas/' + id, {});
            document.getElementById('enunciado').value = response.data.enunciado;
            document.getElementById('opcoes').value = response.data.opcoes;
            document.getElementById('ordem').value = response.data.ordem;
            document.getElementById('tipo_resposta').value = response.data.tipo_resposta;

        },
        async sendForm() {
            let dataForm = {

                entrevista_id:this.$route.params.id,
                enunciado: document.getElementById('enunciado').value,
                opcoes: JSON.stringify(document.getElementById('opcoes').value.split(',')),
                ordem: document.getElementById('ordem').value,
                tipo_resposta: document.getElementById('tipo_resposta').value,

                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas/' + this.$route.params.id, dataForm);
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
        }
    },
    created() {
        this.edit(this.$route.params.id)
    }
}
</script>

<style scoped>

</style>