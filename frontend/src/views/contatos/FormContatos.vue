<template>

        <input-form class-list="col-6" type="string" label="Nome " value="" name="nome"/>
        <input-form class-list="col-6" type="string" label="Razão Social(Opcional\)" value="" name="razao"/>
        <input-form class-list="col-4" type="date" label="Data de nascimento" value="" name="nascimento"/>
        <input-form placeholder="Selecione Estado Civil " class-list="col-4" type="select"
                    :items="[{id:'solteiro',message:'solteiro',},{id:'casado',message:'casado',},{id:'divorciado',message:'divorciado',},{id:'viuvo',message:'viuvo',},]"
                    label="Estado Civil " value="" name="estado_civil"/>
        <input-form placeholder="Selecione Sexo" class-list="col-4" type="select"
                    :items="[{id:'masculino',message:'masculino',},{id:'feminino',message:'feminino',},]" label="Sexo "
                    value="" name="sexo"/>
        <input-form class-list="col-4" type="string" label="RG/IE " value="" name="rg_ie"/>
        <input-form class-list="col-6" type="string" label="CNPJ/CPF " value="" name="cnpj_cpf"/>
        <input-form class-list="col-6" type="string" label="Telefone " value="" name="telefone"/>
        <input-form class-list="col-6" type="string" label="Celular " value="" name="celular"/>
        <input-form class-list="col-4" type="string" label="E-mail " value="" name="email"/>
        <input-form class-list="col-4" type="tinyint" label="Ativo " value="" name="ativo"/>
        <input-form class-list="col-4" type="string" label="Profissão" value="" name="profissao"/>
        <input-form class-list="col-12" type="text" label="Descritivo " value="" name="descritivo"/>


</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormContatos",
    components: {InputForm},
    data() {
        return {contatos: null}
    },
    methods: {
        async getContatos() {
            let request = new RequestHelper();
            this.contatos = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos/list', {});
            this.contatos = await this.contatos.data;

        },


    },
    created() {
        this.getContatos();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>