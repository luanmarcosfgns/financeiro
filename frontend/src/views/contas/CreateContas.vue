<template>
  <layout-page>
    <div class="card-header">
      <div class="row">
        <div class="col-12 ps-4 pt-3 ">
          <div class="float-start">
            <h5>Adicionar Contas</h5>
          </div>
          <div class="float-end">
            <button-widget cor="branco" href="/painel" tamanho="M">
              <i class="bi bi-arrow-right"></i>
            </button-widget>
          </div>
        </div>

      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <FormContas></FormContas>
        <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
      </div>
    </div>
  </layout-page>
</template>
<script>
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import FormContas from "@/views/contas/FormContas.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
  name: "CreateContas",
  components: {FormContas, LayoutPage, ButtonWidget},
  methods: {
    async sendForm() {
      let dataForm = {
        valor: document.getElementById('valor').value,
        tipo: document.getElementById('tipo').value,
        nome: document.getElementById('nome').value,
        mes: document.getElementById('mes').value,


      }
      if (!dataForm.parent_id) {
        delete dataForm.parent_id
      }
      let request = new RequestHelper();
      let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contas', dataForm);
      if (response.data?.id) {
        location.href = '/';
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