<template>
       <input-form class-list="col-12"  type="blob" label="Cotação " value="" name="anexo"/>
       <input-form class-list="col-qw"  type="string" label="Nome " value="" name="nome"/>
       <input-form class-list="col-4"  type="decimal" label="Valor do Premio " value="" name="valor_premio"/>
       <input-form class-list="col-4"  type="decimal" label="Porcentagem da Seguradora " value="" name="porcentagem_seguradora"/>
       <input-form class-list="col-4"  type="decimal" label="Porcentagem da Franqueadora " value="" name="porcentagem_franquiadora"/>
       <input-form class-list="col-4"  type="decimal" label="Porcentagem Maxima de Comissão " value="" name="porcentagem_maxima_vendedor"/>
       <input-form class-list="col-4"  type="decimal" label="Porcentagem Minima de Comissão" value="" name="porcentagem_minima_vendedor"/>
       <input-form class-list="col-4"  type="tinyint" label="Indicar como melhor opção " value="" name="melhor_opcao"/>
       <input-form class-list="col-12"  type="text" label="Descritivo " value="" name="descritivo"/>





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
    methods:{
         async getAnexosVendas(){
            let request =  new RequestHelper();
            this.anexos_vendas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/anexos_vendas/list',{});
             this.anexos_vendas =  await this.anexos_vendas.data;

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