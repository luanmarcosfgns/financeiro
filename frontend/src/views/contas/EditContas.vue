<template>
  <layout-page>
    <div class="card-header">
      <div class="row">
        <div class="col-12 ps-4 pt-3 ">
          <div class="float-start">
            <h5>Editar Contas</h5>
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
import FormContas from "@/views/contas/FormContas.vue";
import RequestHelper from "@/services/RequestHelper";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
  name: "EditContas",
  components: {LayoutPage, ButtonWidget, FormContas},
  methods: {
    async edit(id) {
      let request = new RequestHelper();
      let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contas/' + id, {});
      document.getElementById('valor').value = response.data.valor;
      document.getElementById('tipo').value = response.data.tipo;
      document.getElementById('nome').value = response.data.nome;
      document.getElementById('mes').value = response.data.mes;

    },
    async sendForm() {
      let dataForm = {
        valor: document.getElementById('valor').value,
        tipo: document.getElementById('tipo').value,
        nome: document.getElementById('nome').value,
        mes: document.getElementById('mes').value,


        _method: 'PUT'

      }
      if (!dataForm.parent_id) {
        delete dataForm.parent_id
      }
      let request = new RequestHelper();
      let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contas/' + this.$route.params.id, dataForm);
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