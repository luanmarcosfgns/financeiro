<template>
    <input-form class-list="col-6" type="string" label="Nome pessoal ou empresa " value="" name="fantasia"/>
    <input-form class-list="col-6" type="string" label="Razão social (opcional)" value="" name="razao"/>
    <input-form class-list="col-4" type="string" label="CNPJ/CPF " value="" name="cnpj_cpf"/>
    <input-form class-list="col-4" type="string" label="Incrição Estadual ou RG " value="" name="ie_rg"/>
    <input-form class-list="col-4" type="string" label="Logradouro" value="" name="endereco"/>
    <input-form class-list="col-2" type="string" label="Número " value="" name="numero"/>
    <input-form class-list="col-2" type="string" label="CEP " value="" name="cep"/>
    <input-form class-list="col-4" type="string" label="Telefone (opcional) " value="" name="telefone"/>
    <input-form class-list="col-4" type="string" label="Celular" value="" name="celular"/>

</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormBusiness",
    components: {InputForm},
    data() {
        return {business: null}
    },
    methods: {
        async getBusiness() {
            let request = new RequestHelper();
            this.business = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/business/list', {});
            this.business = await this.business.data;

        },


    },
    created() {
        this.getBusiness();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>