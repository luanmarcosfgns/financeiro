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
                        <input :id="'premio['+servico.servico_id+']'"  type="hidden" :value="servico.valor_premio">
                        <input :id="'comissao_maxima_vendedor['+servico.servico_id+']'"  type="hidden" :value="servico.porcentagem_maxima_vendedor">
                        <input :id="'comissao_minima_vendedor['+servico.servico_id+']'"  type="hidden" :value="servico.porcentagem_minima_vendedor">

                    </div>

                    <div class="col-6 p-3">
                        <div class="row">
                            <div class="col-12 p-1">
                                <input-form :value="servico.desconto" :name="'desconto['+servico.servico_id+']'"  type="decimal" label="Desconto %" ></input-form>
                            </div>
                            <div class="col-12 p-1">
                                <div class="col-12 p-1">
                                    <span class="badge rounded-pill text-bg-primary" style="font-size: 100%">Taxa Franquiadora: R$ {{calculaPorcenategem(servico.valor_premio,servico.porcentagem_franquiadora)}}</span>
                                </div>
                                <div class="col-12 p-1">
                                    <span class="badge rounded-pill text-bg-danger" :id="'comissao_vendedor['+servico.servico_id+']'"  style="font-size: 100%">Comissão Vendedor: R$ {{calculaComissaoVendedor(servico.valor_premio,servico.porcentagem_maxima_vendedor,servico.desconto==null?0:servico.desconto)}}</span>
                                </div>
                                <div class="col-12 p-1">
                                    <span class="badge rounded-pill text-bg-primary" style="font-size: 100%">Seguradora: R$ {{calculaPorcenategem(servico.valor_premio,servico.porcentagem_seguradora)}}</span>

                                </div>
                                <div class="col-12 p-1">
                                    <span class="badge rounded-pill text-bg-primary" style="font-size: 100%">Valor Prêmio: R$ {{calculaPorcenategem(servico.valor_premio,100)}}</span>
                                </div>
                                <div class="col-12 p-1">
                                    <span class="badge rounded-pill text-bg-info" :id="'valor_desconto['+servico.servico_id+']'" style="font-size: 100%">Desconto: R$ {{calculaDescontoVendedorLoad(servico.valor_premio,servico.desconto==null?0:servico.desconto)}}</span>
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
        vendaEdit: JSON
    },
    data() {
        return {
            vendas: null,
            servicos: [],
            totalVenda: 0,
            totalComissao: 0,
            precos: [],
            comissao: null,
            comissaoVendedor:0
        }
    },
    methods: {
        calculaPorcenategem(valor,porcentagem){
            let total =  (porcentagem/100)*valor;
            return new String(total.toFixed(2)).replace('.',',');
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
        onChangeDesconto(){
            setTimeout(()=>{
                let ids =  document.getElementsByClassName('ids');

                for (let i = 0; i < 1; i++) {
                    let id =  ids[i].value;
                    document.getElementById('desconto['+id+']').addEventListener('change',()=>{
                        let descontoPorcento =  document.getElementById('desconto['+id+']').value;
                        let valorPremio = document.getElementById('premio['+id+']').value;
                        let porcentagemMaximaComissao = document.getElementById('comissao_maxima_vendedor['+id+']').value;
                        let porcentagemMinimaComissao = document.getElementById('comissao_minima_vendedor['+id+']').value;
                        console.log(porcentagemMaximaComissao,porcentagemMinimaComissao)
                        if(descontoPorcento <= porcentagemMinimaComissao  || descontoPorcento >= porcentagemMaximaComissao ){
                            document.getElementById('desconto['+id+']').value=0
                            descontoPorcento = 0;

                        }

                        let valor_desconto =  this.calculaDescontoVendedorLoad(valorPremio,descontoPorcento);
                        let comissao_vendedor =  this.calculaComissaoVendedor(valorPremio,porcentagemMaximaComissao,descontoPorcento);

                        document.getElementById('valor_desconto['+id+']').innerHTML='Desconto: R$ '+valor_desconto;
                        document.getElementById('comissao_vendedor['+id+']').innerHTML='Comissão Vendedor: R$ '+comissao_vendedor;
                    });


                }
            },3000)

        },

        setEventos() {
            this.onChangeDesconto();

        },
        calculaDescontoVendedorLoad(valor,desconto){

            let totaldesconto =  (desconto/100)*valor;
            return new String(totaldesconto.toFixed(2)).replace('.',',');

        },
        calculaComissaoVendedor(valor,porcentagem,desconto){
            let totalComissao =  (porcentagem/100)*valor;
            let totaldesconto =  (desconto/100)*valor;
            let total = totalComissao-totaldesconto
            return new String(total.toFixed(2)).replace('.',',');
        }

    },
    mounted() {
        this.getCliente();
        this.getStatus();
        this.getServicos();
        this.getDescritivo();
        this.setEventos();


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