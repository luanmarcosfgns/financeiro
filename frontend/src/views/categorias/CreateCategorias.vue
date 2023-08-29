<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Adicionar Categorias</h5>
                    </div>
                    <div class="float-end">
                        <button-widget cor="azul" href="./index" tamanho="M">
                            Voltar
                        </button-widget>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <FormCategorias></FormCategorias>
                <div class="col-md-4">
                    <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
                </div>
            </div>
        </div>
    </layout-page>
</template>

<script>
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import FormCategorias from "@/views/categorias/FormCategorias.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreateCategorias",
    components: {FormCategorias, LayoutPage, ButtonWidget},
    methods:{
        async sendForm(){
            let dataForm = {
                nome: document.getElementById('nome').value,
                descritivo: document.getElementById('descritivo').value,
                parent_id: document.getElementById('parent_id').value,

            }
            if(!dataForm.parent_id){
                delete dataForm.parent_id
            }
            let request =  new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/categorias',dataForm);
            if(response.data?.id){
                location.href = './'+response.data.id+'/edit';
            }else{
                if (response.response.data?.message){
                    toastr.error(response.response.data?.message);
                }else{
                    toastr.error('Houve um problema ao inserir');
                }

            }
        }
    }
}
</script>

<style scoped>

</style>