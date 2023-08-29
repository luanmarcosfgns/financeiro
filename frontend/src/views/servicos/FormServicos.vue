<template>
    <input-form class-list="col-md-12" type="string" label="Nome " value="" name="nome"/>
    <input-form class-list="col-md-12" type="text" label="Descritivo " value="" name="descritivo"/>
    <input-form class-list="col-md-4" type="tinyint" label="Ecommerce " value="" name="ecommerce"/>
    <input-form class-list="col-md-4" type="double" label="Preco " value="" name="preco"/>
    <input-form placeholder="Selecione Aliquota " class-list="col-md-4" type="select" :items="aliquota"
                label="Aliquota " value="" name="aliquota_id"/>
    <input-form class-list="col-md-4" type="tinyint" label="Ativo " value="" name="ativo"/>
    <input-form placeholder="Selecione Categoria " class-list="col-md-6" type="select" :items="categoria"
                label="Categoria " value="" name="categoria_id"/>


</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormServicos",
    components: {InputForm},
    data() {
        return {servicos: null}
    },
    methods: {
        async getServicos() {
            let request = new RequestHelper();
            this.servicos = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos/list', {});
            this.servicos = await this.servicos.data;

        },


    },
    created() {
        this.getServicos();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>