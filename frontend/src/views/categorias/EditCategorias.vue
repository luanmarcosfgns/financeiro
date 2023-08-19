<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar Categorias</h5>
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
                <FormCategorias></FormCategorias>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>

</template>

<script>
import FormCategorias from "@/views/categorias/FormCategorias.vue";
import RequestHelper from "@/services/RequestHelper";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
    name: "EditCategorias",
    components: {LayoutPage, ButtonWidget, FormCategorias},
    methods:{
       async edit(id){
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/categorias/'+id,{});
           console.log(response.data.descritivo);
            document.getElementById('nome').value = response.data.nome;
            document.getElementById('descritivo').value = response.data.descritivo;
            document.getElementById('parent_id').value = response.data.parent_id;
        },
        async sendForm(){
            let dataForm = {
                nome: document.getElementById('nome').value,
                descritivo: document.getElementById('descritivo').value,
                parent_id: document.getElementById('parent_id').value,
                _method:'PUT'

            }
            if(!dataForm.parent_id){
                delete dataForm.parent_id
            }
            let request =  new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/categorias/'+this.$route.params.id,dataForm);
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