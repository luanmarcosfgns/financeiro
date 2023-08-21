<template>
       <input-form class-list="col-md-12"  type="tinyint" label="Ativo " value="" name="ativo"/>
<input-form class-list="col-md-12"  type="string" label="Bairro " value="" name="bairro"/>
  <input-form placeholder="Selecione Business " class-list="col-md-12" type="select" :items="business" label="Business " value="" name="business_id"/>
<input-form class-list="col-md-12"  type="string" label="Celular " value="" name="celular"/>
<input-form class-list="col-md-12"  type="string" label="Cep " value="" name="cep"/>
<input-form class-list="col-md-12"  type="string" label="Cidade " value="" name="cidade"/>
<input-form class-list="col-md-12"  type="string" label="CNPJ CPF " value="" name="cnpj_cpf"/>
<input-form class-list="col-md-12"  type="text" label="Descritivo " value="" name="descritivo"/>
<input-form class-list="col-md-12"  type="string" label="Email " value="" name="email"/>
<input-form class-list="col-md-12"  type="string" label="Endereço " value="" name="endereco"/>
  <input-form placeholder="Selecione Estado Civil " class-list="col-md-12" type="select" :items="[{id:'solteiro',message:'solteiro',},{id:'casado',message:'casado',},{id:'divorciado',message:'divorciado',},{id:'viuvo',message:'viuvo',},]" label="Estado Civil " value="" name="estado_civil"/>
<input-form class-list="col-md-12"  type="date" label="Nascimento " value="" name="nascimento"/>
<input-form class-list="col-md-12"  type="string" label="Nome " value="" name="nome"/>
<input-form class-list="col-md-12"  type="string" label="Número " value="" name="numero"/>
<input-form class-list="col-md-12"  type="string" label="RG IE " value="" name="rg_ie"/>
  <input-form placeholder="Selecione Sexo " class-list="col-md-12" type="select" :items="[{id:'masculino',message:'masculino',},{id:'feminino',message:'feminino',},]" label="Sexo " value="" name="sexo"/>
<input-form class-list="col-md-12"  type="string" label="Telefone " value="" name="telefone"/>

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