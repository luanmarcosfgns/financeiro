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
        <fieldset>
            <div class="row">
                <div class="col-10">
                    <div class="row">
                        <input-form class-list="col-12 p-2" type="select2" label="Produtos" url="/api/servicos/list"
                                    name="produto_id"/>
                    </div>

                </div>
                <div class="col-2">
                    <div class="col-4 pt-5">
                        <button type="button" class="btn btn-primary" @click="addProdutos">+</button>
                    </div>
                </div>
            </div>


        </fieldset>

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
                        <button @click="deleteServico(servico.id)" class="btn btn-danger">
                            <i class="bi bi-trash2-fill"></i>
                        </button>

                    </div>
                    <div class="col-6 p-3">
                        <div class="row">
                            <input-form class-list="col-12" type="select"
                                        :items="precos[servico.id]" label="Tabela de Preços"
                                        value="" :name="'table_precos['+servico.id+']'"/>
                            <div class="col-6">
                                <input-form label="Preço" placeholder="Preço" type="decimal" :value="servico.preco"
                                            :name="'preco['+servico.id+']'"></input-form>
                            </div>
                            <div class="col-6">
                                <input-form label="Comissão" placeholder="Comissão" type="decimal" :value="servico.comissao"
                                            :name="'comissao['+servico.id+']'"></input-form>
                            </div>
                            <input-form class-list="col-12" label="Desconto%" placeholder="Desconto%" type="decimal" :value="servico.desconto"
                                        :name="'desconto['+servico.id+']'"></input-form>
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
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <div class="col-12">
                        <strong>Comissão:</strong>
                        <h3>{{new String(totalComissao.toFixed(2)).replace('.', ',')}}</h3>
                    </div>
                </div>
            </div>
            <div class="col-6 p-4">
                <h1 class="float-end">R$ {{ new String(totalVenda.toFixed(2)).replace('.', ',') }}</h1>
            </div>
        </div>

    </div>
</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";


export default {
    name: "FormVendas",
    components: {InputForm},
    props: {
        vendaEdit:JSON
    },
    data() {
        return {
            vendas: null,
            servicos: [],
            totalVenda: 0,
            totalComissao:0,
            precos:[]
        }
    },
    methods: {
        async addProdutos() {
            let id = document.getElementById('produto_id').value;


                let helper = new Helpers();
                let request = new RequestHelper();
                let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos/' + id, {});
                if (!helper.empty(response?.data?.id)) {
                    this.servicos.push(response.data);
                    id = '';

            }
            this.getTotalVenda();
            this.getTotalComissao();
            this.getTabelaPreco();
            document.getElementById('produto_id').value = '';
            document.getElementById('search-produto_id').value = '';

        },
        deleteServico(id) {

            let data = [];

            console.log(this.servicos[0])
            for (let i = 0; i < this.servicos.length; i++) {
                if (this.servicos[i].id != id) {
                    data.push(this.servicos[i]);
                }
            }

            this.servicos = data;
        },
        getCliente(){
            let helper = new Helpers();
            if(!helper.empty(this.vendaEdit?.data)){
                this.vendas = this.vendaEdit.data;
                document.getElementById('contato_id').value = this.vendas.contato_id;

            }

        },
        getStatus(){
            let helper = new Helpers();
            if(!helper.empty(this.vendaEdit?.data)){
                this.vendas = this.vendaEdit.data;
                document.getElementById('status').value = this.vendas.status;

            }


        },
        getServicos(){
            let helper = new Helpers();
            if(!helper.empty(this.vendaEdit?.data)){
                this.vendas = this.vendaEdit.data;
               if(!helper.empty(this.vendas?.servicos)){
                   this.servicos = this.vendas.servicos
               }
            }
        },
        getDescritivo(){
            let helper = new Helpers();
            if(!helper.empty(this.vendaEdit?.data)){
                this.vendas = this.vendaEdit.data;
                document.getElementById('descritivo').value = this.vendas.descritivo;

            }
        },
        getTotalVenda(){
            let helper = new Helpers();
            if(!helper.empty(this.vendaEdit?.data)){
                this.vendas = this.vendaEdit.data;
                if(!helper.empty(this.vendas?.servicos)){
                    this.servicos = this.vendas.servicos
                    for (let i in this.servicos) {
                        let total = parseFloat(this.servicos[i].preco);

                        let porcentagem_desconto = parseFloat(this.servicos[i].desconto);
                        this.totalVenda = total- parseFloat((total*porcentagem_desconto)/100)
                        if(isNaN( this.totalVenda)){
                            this.totalVenda = 0;
                        }
                    }

                }
            }

        },
        getTotalComissao(){
            let helper = new Helpers();
            if(!helper.empty(this.vendaEdit?.data)){
                this.vendas = this.vendaEdit.data;
                if(!helper.empty(this.vendas?.servicos)){
                    this.servicos = this.vendas.servicos
                    for (let i in this.servicos) {

                        let total = parseFloat(this.servicos[i].preco);
                        let porcentagem_comissao = parseFloat(this.servicos[i].comissao);
                        this.totalComissao = parseFloat((total*porcentagem_comissao)/100)
                        if(isNaN( this.totalComissao)){
                            this.totalComissao = 0;
                        }

                    }

                }
            }

        },
        getTabelaPreco(){
            let helper = new Helpers();
            if(!helper.empty(this.vendaEdit?.data)){
                this.vendas = this.vendaEdit.data;
                if(!helper.empty(this.vendas?.servicos)){
                    this.servicos = this.vendas.servicos
                    for (let i in this.servicos) {
                       let aliquotas =  this.servicos[i].aliquotas;
                       let data = []
                        for (let j in aliquotas) {
                           data.push({id:aliquotas[j].id,message:aliquotas[j].message});
                        }
                        this.precos[this.servicos[i].id] = data;
                    }

                }
            }

        }

    },
    mounted() {
        this.getCliente();
        this.getStatus();
        this.getServicos();
        this.getDescritivo();
        this.getTotalVenda();
        this.getTotalVenda();
        this.getTotalComissao();
        this.getTabelaPreco();


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