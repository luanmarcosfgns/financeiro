<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Sessions</h5>
                    </div>
                    <div class="float-end">
                        <button-widget cor="azul" href="../index" tamanho="M">
                            Voltar
                        </button-widget>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <FormSessions></FormSessions>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>

</template>

<script>
import FormSessions from "@/views/sessions/FormSessions.vue";
import RequestHelper from "@/services/RequestHelper";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
    name: "EditSessions",
    components: {LayoutPage, ButtonWidget, FormSessions},
    methods: {
        async edit(id) {
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/sessions/' + id, {});
            document.getElementById('nome').value = response.data.nome;
            document.getElementById('descritivo').value = response.data.descritivo;
            document.getElementById('img-image_video').src = response.data.image_video;
            document.getElementById('parent_id').value = response.data.parent_id;
            document.getElementById('link').value = response.data.link;


        },
        async sendForm() {
            let dataForm = {
                nome: document.getElementById('nome').value,
                descritivo: document.getElementById('descritivo').value,
                image_video: document.getElementById('image_video').dataset.value,
                parent_id: document.getElementById('parent_id').value,
                link: document.getElementById('link').value,
                _method: 'PUT'

            }
            if (!dataForm.parent_id) {
                delete dataForm.parent_id
            }
            let request = new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/sessions/' + this.$route.params.id, dataForm);
            if (response.data?.id) {
                toastr.success('Salvo com sucesso')
            } else {
                if (response.response.data?.message) {
                    toastr.error(response.response.data?.message);
                } else {
                    toastr.error('Houve um problema ao inserir');
                }

            }
        }
    },
    created() {
        this.edit(this.$route.params.id)
    }
}
</script>

<style scoped>

</style>