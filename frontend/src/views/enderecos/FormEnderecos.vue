<template>
    <input-form type="hidden" name="contato_id" :value="contatoId"/>
    <input-form class-list="col-md-6" type="string" label="Endereço " value="" name="endereco"/>
    <input-form class-list="col-md-6" type="string" label="Número " value="" name="numero"/>
    <input-form class-list="col-md-4" type="string" label="Bairro " value="" name="bairro"/>
    <input-form class-list="col-md-4" type="string" label="Cidade " value="" name="cidade"/>
    <input-form class-list="col-md-4" type="string" label="Cep " value="" name="cep"/>

</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormEnderecos",
    components: {InputForm},
    data() {
        return {
            enderecos: null,
            contatoId : this.$route.params.id
        }
    },
    methods: {
        async getEnderecos() {
            let request = new RequestHelper();
            this.enderecos = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/enderecos/list', {});
            this.enderecos = await this.enderecos.data;

        },


    },
    created() {
        this.getEnderecos();
    }

}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>