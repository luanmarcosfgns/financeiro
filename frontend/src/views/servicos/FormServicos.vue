<template>
    <input-form class-list="col-12" type="string" label="Nome " value="" name="nome"/>
    <input-form class-list="col-12" type="text" label="Descritivo " value="" name="descritivo"/>
    <input-form class-list="col-4" type="tinyint" label="Ecommerce " value="" name="ecommerce"/>
    <input-form class-list="col-4" type="double" label="Preco " value="" name="preco"/>
    <input-form placeholder="Selecione Aliquota " class-list="col-4" type="select" :items="aliquota"
                label="Aliquota " value="" name="aliquota_id"/>
    <input-form class-list="col-4" type="tinyint" label="Ativo " value="" name="ativo"/>
    <input-form placeholder="Selecione Categoria " class-list="col-6" type="select" :items="categoria"
                label="Categoria " value="" name="categoria_id"/>


</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormServicos",
    components: {InputForm},
    data() {
        return {
            aliquota: null,
            categoria: null
        }
    },
    methods: {
        async getAliquotas() {
            let request = new RequestHelper();
            this.aliquota = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas/list', {});
            this.aliquota = await this.aliquota.data;
            this.categoria = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/categorias/list', {});
            this.categoria = await this.categoria.data;


        },


    },
    created() {
        this.getAliquotas();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>