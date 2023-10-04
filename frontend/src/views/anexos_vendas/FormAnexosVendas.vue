<template>
  <input-form class-list="col-12" type="blob" label="Cotação " value="" name="anexo"/>
  <input-form class-list="col-4" type="string" label="Nome " value="" name="nome"/>
  <input-form class-list="col-4" type="decimal" label="Valor do Premio " value="" name="valor_premio"/>
  <input-form class-list="col-4" type="decimal" label="Comissão Sobre o Premio %" value="" name="comissao"/>
  <input-form class-list="col-4" type="decimal" label="Comissão da Corretora %" value="" name="porcentagem_corretora"/>
  <input-form class-list="col-4" type="decimal" label="Comissão da Franqueadora % " value="" name="porcentagem_franquiadora"/>
  <input-form class-list="col-4" type="decimal" label="Comissão do Vendedor %" value="" name="porcentagem_vendedor"/>
  <input-form class-list="col-4" type="decimal" label="Desconto Maximo" value="" name="desconto"/>
  <input-form class-list="col-4" type="tinyint" label="Indicar como melhor opção " value="" name="melhor_opcao"/>
  <input-form class-list="col-12" type="text" label="Descritivo " value="" name="descritivo"/>


</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
  name: "FormAnexosVendas",
  components: {InputForm},
  data() {
    return {anexos_vendas: null}
  },
  methods: {
    async getAnexosVendas() {
      let request = new RequestHelper();
      this.anexos_vendas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/anexos_vendas/list', {});
      this.anexos_vendas = await this.anexos_vendas.data;

    },


  },
  created() {
    this.getAnexosVendas();
  }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>