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
                <div class="row border border-1" v-for="servico in servicos" :key="servico.id">
                    <div class="col-6 p-3">
                        <strong>Produto:</strong>

                        <br>
                        <br>

                        <span>
                         {{ servico.id }}-{{ servico.nome }}
                        </span>

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
                            <input-form @input="setQuantidade" placeholder="Quantidade" type="decimal" value="1.00"
                                        :name="'quantidade['+servico.id+']'"></input-form>
                        </span>
                        <span>
                            <input-form placeholder="Desconto" type="decimal" value="0.00"
                                        :name="'desconto['+servico.id+']'"></input-form>
                        </span>

                    </div>
                </div>
                <div v-if="servicos.length==0" class="row toast-center">
                    <div class="col-md-12 p-5 text-center">
                        Não há produtos
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <input-form class-list="col--6" type="text" label="Observações" value="" name="descritivo"/>
            <div class="col-6">
                <h4>Aliquotas</h4>
                <ul class="list-aliquotas">
                    <li>Comissão:</li>
                    <li>ICMS:</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="offset-6 col-6 p-4">
                <h1 class="float-end">R$ 90,00</h1>
            </div>
        </div>

    </div>
</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormVendas",
    components: {InputForm},
    data() {
        return {
            vendas: null,
            servicos: []
        }
    },
    methods: {
        async addProdutos() {
            let id = document.getElementById('produto_id').value;
            let label = document.getElementById('search-produto_id').value;
            console.log({id: id})
            if (id != undefined && id != '' && label != undefined && label != '') {
                let request = new RequestHelper();
                let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos/' + id, {});
                if (response.data.id == id) {
                    response.data.quantidade = 1;
                    response.data.desconto = 0;
                    response.data.total = response.data.preco;
                    this.servicos.push(response.data);
                    console.log(response.data)
                    id = '';
                }

            }
            document.getElementById('produto_id').value = '';
            document.getElementById('search-produto_id').value = '';

        },
        setQuantidade() {
            console.log(this.servicos.length);
            for (let i = 0; i < this.servicos.length; i++) {
                console.log(document.getElementById('quantidade[' + this.servicos[i].id + ']').value)
                this.servicos[i].quantidade = document.getElementById('quantidade[' + this.servicos[i].id + ']').value;
                this.servicos[i].total = this.servicos[i].quantidade * this.servicos[i].preco;

            }
        }

    },
    created() {

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