<template>
    <div class="row">
        <div class="col-md-12 ps-4 pt-3 ">
            <div class="float-start">
                <h5>Adicionar Perguntas</h5>
            </div>
            <div class="float-end">
                <button-widget cor="azul" href="./index" tamanho="M">
                    Voltar
                </button-widget>
            </div>
        </div>

    </div>
    <div class="row">
        <FormPerguntas></FormPerguntas>
        <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
    </div>

</template>
<script>
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import FormPerguntas from "@/views/perguntas/FormPerguntas.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreatePerguntas",
    components: {FormPerguntas, ButtonWidget},
    methods: {
        async sendForm() {
            let dataForm = {
                entrevista_id:this.$route.params.id,
                enunciado: document.getElementById('enunciado').value,
                opcoes: JSON.stringify(document.getElementById('opcoes').value.split(',')),
                ordem: document.getElementById('ordem').value,
                tipo_resposta: document.getElementById('tipo_resposta').value,


            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas', dataForm);
            if (response.data?.id) {
                location.href = './' + response.data.id + '/edit';
            } else {
                if (response.response.data?.message) {
                    toastr.error(response.response.data?.message);
                } else {
                    toastr.error('Houve um problema ao inserir');
                }

            }
        }
    }
}
</script>
<style scoped>
</style>