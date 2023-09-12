<template>
    <div class="card-header">
        <div class="row pt-1 pb-5">
            <input-form placeholder="Selecione Clientes " class-list="col-md-12" type="select" :items="contato" label="Cliente "
                        value="" name="contato_id"/>
        </div>

    </div>
    <div class="card-body panel-producs">
        <fieldset>
            <div class="row p-2 ">
                <input-form class-list="col-md-12 p-2" type="string" label="Produtos" value="" name="descritivo"/>
            </div>
        </fieldset>

        <div class="row border border-1 " >
            <div class="col-md-12 p-5 text-center">
                Não há produtos
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <input-form class-list="col-md-6" type="text" label="Observações" value="" name="descritivo"/>
            <div class="col-md-6">
                <h4>Aliquotas</h4>
                <ul class="list-aliquotas" >
                    <li>Comissão:</li>
                    <li>ICMS:</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="offset-6 col-md-6 p-4">
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
        return {vendas: null}
    },
    methods: {
        async getVendas() {
            let request = new RequestHelper();
            this.vendas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/vendas/list', {});
            this.vendas = await this.vendas.data;

        },


    },
    created() {
        this.getVendas();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
.panel-producs{
    background-color: #cbd5e059;
}
.list-aliquotas{
    list-style: none;
}
</style>