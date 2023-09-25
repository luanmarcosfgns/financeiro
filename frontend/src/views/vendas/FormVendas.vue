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
                    <div class="col-6 p-3">
                        <strong>Produto:</strong>
                        <br>
                        <br>
                        <span>
                         {{ servico.servico_id }}-{{ servico.servicos_nome }}
                        </span>
                        <br>

                    </div>
                    <div class="col-6 p-3">
                        <div class="row">
                            <input-form class-list="col-12" type="select"
                                        :items="precos[servico.servico_id]"
                                        @change="setLimits(precos[servico.servico_id])" label="Tabela de Preços"
                                        :value="servico.aliquotas_item_id" :name="'table_precos['+servico.servico_id+']'"/>
                            <div class="col-6">
                                <input-form label="Preço" placeholder="Preço" type="decimal" :value="servico.preco"
                                            :name="'preco['+servico.servico_id+']'"></input-form>
                            </div>
                            <div class="col-6 ">
                                <input-form class-list="col-12" label="Desconto%" placeholder="Desconto%" type="decimal"
                                            :value="servico.desconto"
                                            :name="'desconto['+servico.servico_id+']'"></input-form>
                            </div>
                            <div class="col-12 pt-4">
                                <strong>Comissão Prevista:</strong>
                                <span :id="'comissao['+servico.servico_id+']'">  {{servico.comissao?' '+new String(servico.comissao).replace('.',',')+' %':' 0,00 %'}}</span>
                            </div>
                            <input type="hidden" class="id" :value="servico.servico_id">
                            <input type="hidden"    :id="'comissao_input['+servico.servico_id+']'" value="0">

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
import RequestHelper from "@/services/RequestHelper";


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
            comissao: null
        }
    },
    methods: {
        setLimits(precos) {
            console.log(precos)
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
        getTotalVenda() {
            let helper = new Helpers();
            if (!helper.empty(this.vendaEdit?.data)) {
                this.vendas = this.vendaEdit.data;
                if (!helper.empty(this.vendas?.servicos)) {
                    this.servicos = this.vendas.servicos
                    for (let i in this.servicos) {
                        let total = parseFloat(this.servicos[i].preco);

                        let porcentagem_desconto = parseFloat(this.servicos[i].desconto);
                        this.totalVenda = total - parseFloat((total * porcentagem_desconto) / 100)
                        if (isNaN(this.totalVenda)) {
                            this.totalVenda = 0;
                        }
                    }

                }
            } else {

                for (let i in this.servicos) {
                    let total = parseFloat(this.servicos[i].preco);
                    console.log(total)
                    let porcentagem_desconto = parseFloat(this.servicos[i].desconto);
                    if (isNaN(porcentagem_desconto)) {
                        this.totalVenda = total;
                    } else {
                        this.totalVenda = total - parseFloat((total * porcentagem_desconto) / 100)
                    }

                    console.log(this.totalVenda)
                    if (isNaN(this.totalVenda)) {
                        this.totalVenda = 0;
                    }
                }
            }

        },
        getTotalComissao() {
            let helper = new Helpers();
            if (!helper.empty(this.vendaEdit?.data)) {
                this.vendas = this.vendaEdit.data;
                if (!helper.empty(this.vendas?.servicos)) {
                    this.servicos = this.vendas.servicos
                    for (let i in this.servicos) {

                        let total = parseFloat(this.servicos[i].preco);
                        let porcentagem_comissao = parseFloat(this.servicos[i].comissao);
                        this.totalComissao = parseFloat((total * porcentagem_comissao) / 100)
                        if (isNaN(this.totalComissao)) {
                            this.totalComissao = 0;
                        }

                    }

                }
            }

        },
        getTabelaPreco() {
            let helper = new Helpers();

            if (!helper.empty(this.vendaEdit?.data)) {
                this.vendas = this.vendaEdit.data;
                if (!helper.empty(this.vendas?.servicos)) {
                    this.servicos = this.vendas.servicos
                    for (let i in this.servicos) {
                        let aliquotas = this.servicos[i].aliquotas;
                        let data = []
                        for (let j in aliquotas) {
                            data.push({id: aliquotas[j].id, message: aliquotas[j].message});
                        }

                        this.precos[this.servicos[i].servico_id] = data;
                        console.log(this.precos)

                    }

                }
            }

        },
        onChangeDesconto(){
            setTimeout(async () => {
                    for (let i = 0; i < this.servicos.length; i++) {
                        document.getElementById('desconto[' + this.servicos[i].servico_id + ']').addEventListener('input', async ()=>{
                           let desconto =  document.getElementById('desconto[' + this.servicos[i].servico_id + ']');
                           let comissao =  document.getElementById('comissao[' + this.servicos[i].servico_id + ']');
                           let comissaoInput =  document.getElementById('comissao_input[' + this.servicos[i].servico_id + ']');
                            let table_precos =  document.getElementById('table_precos[' + this.servicos[i].servico_id + ']');
                            let aliquotaItem  = await this.adquirirAliquoitas(table_precos.value);
                            let valorMaximoDesconto = parseFloat(aliquotaItem.data.desconto_porcentagem)+parseFloat(aliquotaItem.data.porcentagem_comissao);

                            if(valorMaximoDesconto>=desconto.value && desconto.value>=aliquotaItem.data.desconto_porcentagem){
                               let  comissaoDisplay = valorMaximoDesconto - parseFloat(desconto.value).toFixed(2);
                                 comissaoInput.value = comissaoDisplay;
                                comissao.innerHTML= new String((comissaoDisplay)).replace('.',',')+' %';
                            }else{
                                desconto.value = valorMaximoDesconto;
                            }
                        })
                    }
            }, 2000)
        },
        onChangePrecos() {
            setTimeout(async () => {

                for (let i = 0; i < this.servicos.length; i++) {
                    document.getElementById('preco[' + this.servicos[i].servico_id + ']').readOnly = true;
                    document.getElementById('desconto[' + this.servicos[i].servico_id + ']').readOnly = true;
                    document.getElementById('desconto[' + this.servicos[i].servico_id + ']').readOnly = true;
                    document.getElementById('table_precos[' + this.servicos[i].servico_id + ']').addEventListener('input', async ()=>{

                        let table_precos =  document.getElementById('table_precos[' + this.servicos[i].servico_id + ']');
                        let aliquotaItem  = await this.adquirirAliquoitas(table_precos.value);
                        document.getElementById('preco[' + this.servicos[i].servico_id + ']').value = aliquotaItem.data.valor;
                        document.getElementById('desconto[' + this.servicos[i].servico_id + ']').value = aliquotaItem.data.desconto_porcentagem;
                        document.getElementById('comissao[' + this.servicos[i].servico_id + ']').innerHTML = new String(aliquotaItem.data.porcentagem_comissao).replace('.',',')+' %';

                        document.getElementById('comissao_input[' + this.servicos[i].servico_id + ']').value = aliquotaItem.data.porcentagem_comissao;
                        console.log(aliquotaItem.data.porcentagem_comissao)
                        document.getElementById('preco[' + this.servicos[i].servico_id + ']').readOnly = false;
                        document.getElementById('desconto[' + this.servicos[i].servico_id + ']').readOnly = false;

                    });

                }
            }, 2000)

        },
        async adquirirAliquoitas(id){
            let request = new RequestHelper();
            return request.getAuth(process.env.VUE_APP_API_HOST_NAME +'/api/aliquotas_items/'+id,{});

        },
        setEventos() {
            this.onChangePrecos()
            this.onChangeDesconto()
        }

    },
    mounted() {
        this.getCliente();
        this.getStatus();
        this.getServicos();
        this.getDescritivo();
        this.getTotalVenda();
        this.getTotalComissao();
        this.getTabelaPreco();
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