<template>
    <input-form class-list="col-12" type="string" label="Nome " value="" name="nome"/>
    <input-form class-list="col-12" type="text" label="Descritivo " value="" name="descritivo"/>
    <input-form class-list="col-12" type="tinyint" label="Ativo " value="" name="ativo"/>


</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormAliquotas",
    components: {InputForm},
    data() {
        return {aliquotas: null}
    },
    methods: {
        async getAliquotas() {
            let request = new RequestHelper();
            this.aliquotas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/aliquotas/list', {});
            this.aliquotas = await this.aliquotas.data;

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