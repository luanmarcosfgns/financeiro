<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Configurações</h5>
                    </div>

                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <FormBusiness></FormBusiness>
                <div class="col-md-4">
                    <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
                </div>

            </div>
        </div>
    </layout-page>

</template>

<script>
import FormBusiness from "@/views/business/FormBusiness.vue";
import RequestHelper from "@/services/RequestHelper";

import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
    name: "EditBusiness",
    components: {LayoutPage, FormBusiness},
    methods:{
       async edit(id){
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/business/'+id,{});
           document.getElementById('fantasia').value = response.data.fantasia;
document.getElementById('razao').value = response.data.razao;
document.getElementById('cnpj_cpf').value = response.data.cnpj_cpf;
document.getElementById('ie_rg').value = response.data.ie_rg;
document.getElementById('endereco').value = response.data.endereco;
document.getElementById('numero').value = response.data.numero;
document.getElementById('cep').value = response.data.cep;
document.getElementById('telefone').value = response.data.telefone;
document.getElementById('celular').value = response.data.celular;

        },
        async sendForm(){
            let dataForm = {
                  fantasia: document.getElementById('fantasia').value,
razao: document.getElementById('razao').value,
cnpj_cpf: document.getElementById('cnpj_cpf').value,
ie_rg: document.getElementById('ie_rg').value,
endereco: document.getElementById('endereco').value,
numero: document.getElementById('numero').value,
cep: document.getElementById('cep').value,
telefone: document.getElementById('telefone').value,
celular: document.getElementById('celular').value,

                _method:'PUT'

            }
            if(!dataForm.parent_id){
                delete dataForm.parent_id
            }
            let request =  new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/business/'+this.$route.params.id,dataForm);
            if(response.data?.id){
               toastr.success('Salvo com sucesso')
            }else{
                if (response.response.data?.message){
                    toastr.error(response.response.data?.message);
                }else{
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