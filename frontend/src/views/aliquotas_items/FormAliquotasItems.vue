<template>
    <input-form class-list="col-12" type="string" label="Nome " value="" name="nome"/>
    <input-form class-list="col-12" type="decimal" label="Valor Base " value="" name="valor"/>
    <input-form class-list="col-12" type="decimal" label="Porcentagem de Prêmio" value="" name="porcentagem_comissao"/>
    <input-form class-list="col-12" type="decimal" label="Desconto Máximo " value="" name="desconto_porcentagem"/>

</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormAliquotasItems",
    components: {InputForm},
    data() {
        return {aliquotas_items: null}
    },
    methods: {
        async getAliquotasItems() {
            let request = new RequestHelper();
            this.aliquotas_items = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas_items/list', {});
            this.aliquotas_items = await this.aliquotas_items.data;

        },


    },
    created() {
        this.getAliquotasItems();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>