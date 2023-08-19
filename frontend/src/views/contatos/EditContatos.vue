<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Contatos</h5>
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
                <FormContatos></FormContatos>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
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

export default {
    name: "EditContatos",
    components: {LayoutPage, ButtonWidget, FormContatos},
    methods:{
       async edit(id){
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos/'+id,{});
           document.getElementById('ativo').value = response.data.ativo;
document.getElementById('bairro').value = response.data.bairro;
document.getElementById('business_id').value = response.data.business_id;
document.getElementById('celular').value = response.data.celular;
document.getElementById('cep').value = response.data.cep;
document.getElementById('cidade').value = response.data.cidade;
document.getElementById('cnpj_cpf').value = response.data.cnpj_cpf;
document.getElementById('descritivo').value = response.data.descritivo;
document.getElementById('email').value = response.data.email;
document.getElementById('endereco').value = response.data.endereco;
document.getElementById('estado_civil').value = response.data.estado_civil;
document.getElementById('nascimento').value = response.data.nascimento;
document.getElementById('nome').value = response.data.nome;
document.getElementById('numero').value = response.data.numero;
document.getElementById('rg_ie').value = response.data.rg_ie;
document.getElementById('sexo').value = response.data.sexo;
document.getElementById('telefone').value = response.data.telefone;

        },
        async sendForm(){
            let dataForm = {
                  ativo: document.getElementById('ativo').value,
bairro: document.getElementById('bairro').value,
business_id: document.getElementById('business_id').value,
celular: document.getElementById('celular').value,
cep: document.getElementById('cep').value,
cidade: document.getElementById('cidade').value,
cnpj_cpf: document.getElementById('cnpj_cpf').value,
descritivo: document.getElementById('descritivo').value,
email: document.getElementById('email').value,
endereco: document.getElementById('endereco').value,
estado_civil: document.getElementById('estado_civil').value,
nascimento: document.getElementById('nascimento').value,
nome: document.getElementById('nome').value,
numero: document.getElementById('numero').value,
rg_ie: document.getElementById('rg_ie').value,
sexo: document.getElementById('sexo').value,
telefone: document.getElementById('telefone').value,

                _method:'PUT'

            }
            if(!dataForm.parent_id){
                delete dataForm.parent_id
            }
            let request =  new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos/'+this.$route.params.id,dataForm);
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