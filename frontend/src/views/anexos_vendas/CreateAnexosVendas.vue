<template>
  <layout-page>
    <div class="card-header">
      <div class="row">
        <div class="col-12 ps-4 pt-3 ">
          <div class="float-start">
            <h5>Adicionar Cotações</h5>
          </div>
          <div class="float-end">
            <button class="btn btn-primary" @click="goBack">
              Voltar
            </button>
          </div>
        </div>

      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <FormAnexosVendas></FormAnexosVendas>
        <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
      </div>
    </div>
  </layout-page>
</template>
<script>

import LayoutPage from "@/components/page/layoutPage.vue";
import FormAnexosVendas from "@/views/anexos_vendas/FormAnexosVendas.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";


export default {
  name: "CreateAnexosVendas",
  components: {FormAnexosVendas, LayoutPage},
  methods: {
    async sendForm() {
      console.log(document.getElementById('anexo').dataset)
      let dataForm = {
        nome: document.getElementById('nome').value,
        anexo: document.getElementById('anexo').dataset.value,
        valor_premio: document.getElementById('valor_premio').value,
        comissao: document.getElementById('comissao').value,
        porcentagem_corretora: document.getElementById('porcentagem_corretora').value,
        porcentagem_franquiadora: document.getElementById('porcentagem_franquiadora').value,
        porcentagem_vendedor: document.getElementById('porcentagem_vendedor').value,
        melhor_opcao: document.getElementById('melhor_opcao').value,
        desconto: document.getElementById('desconto').value,
        descritivo: document.getElementById('descritivo').value,
        venda_id: this.$route.params.id,


      }
      console.log(dataForm)
      let request = new RequestHelper();
      let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/anexos_vendas', dataForm);
      if (response.data?.id) {
        history.back();
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
  }
}
</script>
<style scoped>
</style>