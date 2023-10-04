<template>
  <div class="card-header">
    <div class="row pt-1 pb-5">
      <div class="col-8">
        <input-form type="select2" url="/api/contatos/list" label="Cliente" name="contato_id"></input-form>
      </div>
      <div class="col-4">

        <input-form placeholder="Selecione status" class-list="col-12" type="select"
                    :items="[{id:'novo',message:'Novo',},{id:'pendente',message:'Pendente',},{id:'negado',message:'Negado',},{id:'finalizado',message:'Finalizado',}]"
                    label="Status"
                    value="novo" name="status"/>
      </div>


    </div>

  </div>
  <div class="card-body panel-producs">


    <div class="row border border-1 ">
      <div class="col-12 ">
        <div class="row border border-1" v-for="servico in servicos" :key="servico">
          <div class="col-4 p-3">
            <strong>Produto:</strong>
            <br>
            <span>
                         {{ servico.servico_id }}-{{ servico.servicos_nome }}
                        </span>
            <input class="ids" type="hidden" :value="servico.servico_id">
            <input :id="'premio['+servico.servico_id+']'" type="hidden" :value="servico.valor_premio">
            <input :id="'comissao_maxima_vendedor['+servico.servico_id+']'" type="hidden"
                   :value="servico.porcentagem_maxima_vendedor">
            <input :id="'comissao_minima_vendedor['+servico.servico_id+']'" type="hidden"
                   :value="servico.porcentagem_minima_vendedor">

          </div>

          <div class="col-6 p-3">
            <div class="row">
              <div class="col-12 p-1">
                <label>Desconto %</label>
                <br>
                <input type="number" :id="'desconto['+servico.servico_id+']'"
                   v-model="descontoPorcentagem"    @change="calculaDesconto()">

              </div>
              <div class="col-12 p-1">
                <div class="col-12 p-1">
                  <span class="badge rounded-pill text-bg-primary"
                        style="font-size: 100%">% Franquiadora: R$ {{ franqueadoraValor }}</span>

                </div>
                <div class="col-12 p-1">
                  <span class="badge rounded-pill text-bg-danger" :id="'comissao_vendedor['+servico.servico_id+']'"
                        style="font-size: 100%">Comissão Vendedor: R$ {{ vendedorValor }}</span>

                </div>
                <div class="col-12 p-1">
                  <span class="badge rounded-pill text-bg-primary"
                        style="font-size: 100%">Corretora: R$ {{ corretoraValor }}</span>

                </div>
                <div class="col-12 p-1">
                  <span class="badge rounded-pill text-bg-primary"
                        style="font-size: 100%">Valor Prêmio: R$ {{ premioValor }}</span>
                </div>
                <div class="col-12 p-1">
                  <span class="badge rounded-pill text-bg-info" :id="'valor_desconto['+servico.servico_id+']'"
                        style="font-size: 100%">Desconto: R$ {{ new String(descontoValor.toFixed(2)).replace('.',',') }}</span>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div v-if="servicos.length==0" class="row toast-center">
          <div class="col-12 p-5 text-center">
            Não há produtos
          </div>

        </div>

      </div>
    </div>
  </div>
  <div class="card-footer">
    <div class="row">
      <input-form class-list="col--6" type="text" label="Observações" value="" name="descritivo"/>
    </div>

  </div>
</template>

<script>
import InputForm from "@/components/form/inputForm.vue";

import Helpers from "@/services/Helpers";


export default {
  name: "FormVendas",
  components: {InputForm},
  props: {
    vendaEdit: JSON,
    selecionado: JSON
  },
  data() {
    return {
      vendas: null,
      servicos: [],
      servico_comissao: [],
      franqueadoraValor: 0,
      vendedorValor: 0,
      corretoraValor: 0,
      descontoValor: 0,
      premioValor: 0,
      descontoPorcentagem: 0,

    }
  },
  methods: {
    calculaPorcentagem(valor, porcentagem) {
      let total = (porcentagem / 100) * valor;
      return new String(total.toFixed(2)).replace('.', ',');
    },

    getCliente() {
      let helper = new Helpers();
      if (!helper.empty(this.vendaEdit?.data)) {
        this.vendas = this.vendaEdit.data;
        document.getElementById('contato_id').value = this.vendas.contato_id;

      }

    },
    getStatus() {
      let helper = new Helpers();
      if (!helper.empty(this.vendaEdit?.data)) {
        this.vendas = this.vendaEdit.data;
        document.getElementById('status').value = this.vendas.status;

      }


    },
    getServicos() {
      let helper = new Helpers();
      if (!helper.empty(this.vendaEdit?.data)) {
        this.vendas = this.vendaEdit.data;
        if (!helper.empty(this.vendas?.servicos)) {
          this.servicos = this.vendas.servicos

        }

      }
    },
    getDescritivo() {
      let helper = new Helpers();
      if (!helper.empty(this.vendaEdit?.data)) {
        this.vendas = this.vendaEdit.data;
        document.getElementById('descritivo').value = this.vendas.descritivo;

      }
    },
    getLucros() {

      this.franqueadoraValor = this.calculaPorcentagem(this.servico_comissao.valor_premio, this.servico_comissao.porcentagem_franquiadora);
      this.vendedorValor = this.calculaComissaoVendedor(this.servico_comissao.valor_premio, this.servico_comissao.porcentagem_vendedor);
      this.corretoraValor = this.calculaPorcentagem(this.servico_comissao.valor_premio, this.servico_comissao.porcentagem_corretora);
      this.descontoValor = 0;
      this.premioValor = this.calculaPorcentagem(this.servico_comissao.valor_premio, 100);
      this.descontoPorcentagem = this.servico_comissao.desconto

    },
    setEventos() {


    },
    calculaDesconto() {
      console.log(this.descontoPorcentagem)
      if (this.descontoPorcentagem > this.selecionado.desconto) {
        this.descontoPorcentagem = this.selecionado.desconto
      }
      this.descontoValor = (( this.descontoPorcentagem* this.servico_comissao.valor_premio) / 100);
      let helper = new Helpers();
      if (helper.empty(this.descontoValor)) {
        this.descontoValor = 0;
      }
      let premio = (this.servico_comissao.valor_premio - this.descontoValor);
      this.franqueadoraValor = this.calculaPorcentagem(premio, this.servico_comissao.porcentagem_franquiadora);
      this.vendedorValor = this.calculaComissaoVendedor(premio, this.servico_comissao.porcentagem_vendedor);
      this.corretoraValor = this.calculaPorcentagem(premio, this.servico_comissao.porcentagem_corretora);
      this.premioValor = this.calculaPorcentagem(premio, 100);


    },
    calculaComissaoVendedor(valor, porcentagem) {
      let total = (porcentagem / 100) * valor;

      return new String(total.toFixed(2)).replace('.', ',');
    },
    servicoComissao() {
      this.servico_comissao = this.selecionado;
    }

  },
  mounted() {
    this.getCliente();
    this.getStatus();
    this.getServicos();
    this.getDescritivo();
    this.servicoComissao();
    this.setEventos();
    this.getLucros();


  },


}
</script>

<style scoped>
@import "toastr/build/toastr.css";

.panel-producs {
  background-color: #cbd5e059;
}

.list-aliquotas {
  list-style: none;
}
</style>