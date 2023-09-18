<template>
    <div class="card-header">
        <div class="row pt-1 pb-5">
            <div class="col-6">
                <input-form type="select2" url="/api/contatos/list" label="Cliente" name="contato_id"></input-form>
            </div>
            <div class="col-3">
                <input-form class-list="col--12" type="select"
                            :items="[{id:'venda',message:'Venda',},{id:'orcamento',message:'Orçamento',}]"
                            label="Tipo "
                            value="venda" name="tipo"/>
            </div>
            <div class="col-3">

                <input-form placeholder="Selecione status" class-list="col--12" type="select"
                            :items="[{id:'novo',message:'Novo',},{id:'pendente',message:'Pendente',},{id:'negado',message:'Negado',}]"
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
                         {{ servico.id }}-{{ servico.nome }}
                        </span>
                        <br>
                        <button @click="deleteServico(servico.id)" class="btn btn-danger">
                            <i class="bi bi-trash2-fill"></i>
                        </button>

                    </div>
                    <div class="col-6 p-3">
                        <div class="row">
                            <div class="col-6 p-2">
                                <strong>Preço:</strong>
                                <span>
                            R$
                        {{ new String(servico.preco).replace('.', ',') }}
                        </span>
                            </div>
                            <div class="col-6 p-2">
                                <strong>Valor Total:</strong>
                                <span>
                            R$
                        {{ new String(servico.total).replace('.', ',') }}
                        </span>
                            </div>
                        </div>


                        <br>
                        <span>
                            <input-form label="Quantidade" placeholder="Quantidade" type="decimal" value="1.00"
                                        :name="'quantidade['+servico.id+']'"></input-form>
                        </span>
                        <span>
                            <input-form label="Desconto%" placeholder="Desconto%" type="decimal" value="0.00"
                                        :name="'desconto['+servico.id+']'"></input-form>
                        </span>

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
            <div class="offset-6 col-6 p-4">
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
    data() {
        return {
            vendas: null,
            servicos: [],
            totalVenda: 0
        }
    },
    methods: {
        async addProdutos() {
            let id = document.getElementById('produto_id').value;
            let label = document.getElementById('search-produto_id').value;
            let addNewRow = true;

            if (id != undefined && id != '' && label != undefined && label != '') {
                let request = new RequestHelper();
                let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos/' + id, {});
                if (response.data.id == id) {
                    for (let i = 0; i < this.servicos.length; i++) {
                        if (this.servicos[i].id == id) {
                            let quantidade = parseFloat(this.servicos[i].quantidade) + 1;
                            document.getElementById('quantidade[' + this.servicos[i].id + ']').value = quantidade;


                            addNewRow = false;
                        }
                    }
                    if (addNewRow) {

                        response.data.quantidade = 1;
                        response.data.desconto = 0;
                        response.data.total = response.data.preco;
                        this.servicos.push(response.data);

                        id = '';
                    }

                }

            }
            document.getElementById('produto_id').value = '';
            document.getElementById('search-produto_id').value = '';
            console.log(this.servicos)
        },
        setQuantidadeDesconto() {
            let helper = new Helpers();
            for (let i = 0; i < this.servicos.length; i++) {
                if (!helper.empty(this.servicos[i])) {
                    this.servicos[i].quantidade = document.getElementById('quantidade[' + this.servicos[i].id + ']').value;
                    this.servicos[i].desconto = document.getElementById('desconto[' + this.servicos[i].id + ']').value;

                    let totalSemDesconto = this.servicos[i].quantidade * this.servicos[i].preco;

                    let ValorDesconto = ((totalSemDesconto * this.servicos[i].desconto) / 100);
                    let ValorComDesconto = totalSemDesconto - ValorDesconto;


                    this.servicos[i].total = (ValorComDesconto).toFixed(2);
                }


            }
        },
        setTotalVenda() {
            let helper = new Helpers();
            this.totalVenda = 0;
            for (let i = 0; i < this.servicos.length; i++) {
                if (!helper.empty(this.servicos[i])) {
                    this.totalVenda += parseFloat(this.servicos[i].total);
                }

            }
        },
        async loadPDV() {
            let helper = new Helpers();


            if (helper.isJsonString(localStorage.getItem('venda'))) {
                let venda = JSON.parse(localStorage.getItem('venda'));
                console.log(venda)
                if (!helper.empty(venda?.servicos)) {
                    this.servicos = venda.servicos;
                }
                if (!helper.empty(venda?.contato_id)) {
                    document.getElementById('contato_id').value = venda.contato_id;
                }
                if (!helper.empty(venda?.tipo)) {
                    document.getElementById('tipo').value = venda.tipo;
                }

                if (!helper.empty(venda?.status)) {
                    document.getElementById('status').value = venda.status;
                }
                if (!helper.empty(venda?.descritivo)) {
                    document.getElementById('descritivo').value = venda.descritivo;
                }
                console.log(venda)

            }
            localStorage.removeItem('venda');

        },
        setDataPDV() {
            let helper = new Helpers();
            let venda = {
                servicos: null,
                contato_id: null,
                tipo: null,
                status: null,
                descritivo: null,
            };
            if (!helper.empty(this.servicos)) {
                venda.servicos = this.servicos
            }else{
                venda.servicos =  JSON.parse(localStorage.getItem('venda'))?.servicos;

            }

            if (!helper.empty(document.getElementById('contato_id')?.value)) {
                venda.contato_id = document.getElementById('contato_id').value;
            }

            if (!helper.empty(document.getElementById('tipo')?.value)) {

                venda.tipo = document.getElementById('tipo')?.value;
            }

            if (!helper.empty(document.getElementById('status')?.value)) {
                venda.status = document.getElementById('status').value;
            }
            if (!helper.empty(document.getElementById('descritivo')?.value)) {
                venda.descritivo = document.getElementById('descritivo').value;
            }

            localStorage.setItem('venda', undefined);
            localStorage.setItem('venda', JSON.stringify(venda));

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
        }

    },
    mounted() {
        this.loadPDV();
        let locationUrl = window.location.url;
        let interval = setInterval(() => {
            if (locationUrl == window.location.url) {
                this.setQuantidadeDesconto()
                this.setTotalVenda()
                this.setDataPDV()
            } else {
                clearInterval(interval);
            }
        }, 500);


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