<template>
    <input-form class-list="col-12"  type="string" label="Nome " value="" name="servicos_anexos_nome"/>
    <input-form class-list="col-12"  type="text" label="Descritivo " value="" name="servicos_anexos_descritivo"/>
    <input-form class-list="col-12"  type="tinyint" label="Ativo " value="" name="servicos_anexos_ativo"/>

</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormEntrevistas",
    components: {InputForm},
    data() {
        return {entrevistas: null}
    },
    methods:{
         async getEntrevistas(){
            let request =  new RequestHelper();
            this.entrevistas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/entrevistas/list',{});
             this.entrevistas =  await this.entrevistas.data;

        },


    },
    created() {
        this.getEntrevistas();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>