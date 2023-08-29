<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Adicionar Servicos</h5>
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
                <FormServicos></FormServicos>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>
</template>
<script>
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import FormServicos from "@/views/servicos/FormServicos.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "CreateServicos",
    components: {FormServicos, LayoutPage, ButtonWidget},
    methods:{
        async sendForm(){
            let dataForm = {
              nome: document.getElementById('nome').value,
descritivo: document.getElementById('descritivo').value,
ecommerce: document.getElementById('ecommerce').value,
preco: document.getElementById('preco').value,
aliquota_id: document.getElementById('aliquota_id').value,
categoria_id: document.getElementById('categoria_id').value,
ativo: document.getElementById('ativo').value,
business_id: document.getElementById('business_id').value,


            }
            if(!dataForm.parent_id){
                delete dataForm.parent_id
            }
            let request =  new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos',dataForm);
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