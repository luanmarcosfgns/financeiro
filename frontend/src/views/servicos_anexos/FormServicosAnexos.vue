<template>
    <input-form class-list="col-12" type="blob" label="Anexo " value="" name="anexo"/>
    <input-form placeholder="Selecione Tipo " class-list="col-12" type="select"
                :items="[{id:'produto',message:'produto',},{id:'imagem',message:'imagem',},{id:'documento',message:'documento',},]"
                label="Tipo " value="" name="tipo"/>
    <input type="hidden" name="servico_id" :value="servico_id">

</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormServicosAnexos",
    components: {InputForm},
    data() {
        return {
            servicos_anexos: null,
            servico_id:this.$route.params.id
        }
    },
    methods: {
        async getServicosAnexos() {
            let request = new RequestHelper();
            this.servicos_anexos = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/servicos_anexos/list', {});
            this.servicos_anexos = await this.servicos_anexos.data;

        },


    },
    created() {
        this.getServicosAnexos();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>