<template>
       <input-form class-list="col-md-12"  type="tinyint" label="Ativo" value="" name="ativo"/>
<input-form class-list="col-md-12"  type="string" label="Bairro" value="" name="bairro"/>
  <input-form placeholder="SelecioneBusinesss" class-list="col-md-12" type="select" :items="businesss" label="businesss" value="" name="business_id"/>
<input-form class-list="col-md-12"  type="string" label="Celular" value="" name="celular"/>
<input-form class-list="col-md-12"  type="string" label="Cep" value="" name="cep"/>
<input-form class-list="col-md-12"  type="string" label="Cidade" value="" name="cidade"/>
<input-form class-list="col-md-12"  type="string" label="Cnpj_cpf" value="" name="cnpj_cpf"/>
<input-form class-list="col-md-12"  type="text" label="Descritivo" value="" name="descritivo"/>
<input-form class-list="col-md-12"  type="string" label="Email" value="" name="email"/>
<input-form class-list="col-md-12"  type="string" label="Endereco" value="" name="endereco"/>
  <input-form placeholder="SelecioneEstado_civil" class-list="col-md-12" type="select" :items="[{id:,,message:,,}]" label="Estado_civil" value="" name="estado_civil"/>
<input-form class-list="col-md-12"  type="date" label="Nascimento" value="" name="nascimento"/>
<input-form class-list="col-md-12"  type="string" label="Nome" value="" name="nome"/>
<input-form class-list="col-md-12"  type="string" label="Numero" value="" name="numero"/>
<input-form class-list="col-md-12"  type="string" label="Rg_ie" value="" name="rg_ie"/>
  <input-form placeholder="SelecioneSexo" class-list="col-md-12" type="select" :items="[{id:,,message:,,}]" label="Sexo" value="" name="sexo"/>
<input-form class-list="col-md-12"  type="string" label="Telefone" value="" name="telefone"/>

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
    methods:{
         async getContatos(){
            let request =  new RequestHelper();
            this.contatos = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contatos/list',{});
             this.contatos =  await this.contatos.data;

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