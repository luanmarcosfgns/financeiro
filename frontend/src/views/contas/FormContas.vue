<template>
  <input-form class-list="col-12" type="string" label="Nome " value="" name="nome"/>
  <input-form class-list="col-12" type="decimal" label="Valor " value="" name="valor"/>
  <input-form placeholder="Selecione Tipo " class-list="col-12" type="select"
              :items="[{id:'conta',message:'Tenho',},{id:'despesa',message:'Devo',},]" label="Tipo " value=""
              name="tipo"/>
  <input-form placeholder="Selecione Mês " class-list="col-12" type="select"
              :items="[
                  {id:'1',message:'Janeiro'},
                  {id:'2',message:'Fevereiro'},
                  {id:'3',message:'Março'},
                  {id:'4',message:'Abril'},
                  {id:'5',message:'Maio'},
                  {id:'6',message:'Junho'},
                  {id:'7',message:'Julho'},
                  {id:'8',message:'Agosto'},
                  {id:'9',message:'Setembro'},
                  {id:'10',message:'Outubro'},
                  {id:'11',message:'Novembro'},
                  {id:'12',message:'Dezembro'}
                  ]"
              label="Mês " value=""
              name="mes"/>

</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
  name: "FormContas",
  components: {InputForm},
  data() {
    return {contas: null}
  },
  methods: {
    async getContas() {
      let request = new RequestHelper();
      this.contas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contas/list', {});
      this.contas = await this.contas.data;

    },


  },
  created() {
    this.getContas();
  }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>