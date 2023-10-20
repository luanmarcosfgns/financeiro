<template>
  <layout-page>
    <div class="card-header">
      <div class="row">
        <div class="col-6 pt-3 text-center  ">
          <button class="button-circle bg-danger">
            <span class="button-title">Devo:</span>
            <br>
            <span class="tenho">R$ {{ new String(tenho).replace('.', ',') }}</span>
          </button>

        </div>
        <div class="col-6 pt-3 text-center border-left ">

          <button class="button-circle bg-primary">
            <span class="button-title">Tenho:</span>
            <br>
            <span class="tenho">R$ {{ new String(devo).replace('.', ',') }}</span>
          </button>

        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-8">
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
                      label="Mẽs " :value="mes"
                      name="mes"/>
        </div>
        <div class="col-4 pt-4 text-center ">
          <router-link class="btn btn-primary" to="/contas/create">Novo</router-link>
        </div>
      </div>
    </div>


    <div class="card-body " id="list-transactions">
      <div class="row" v-for="row in rows" v-bind:key="row">

        <div class="col-12  p-2 border-bottom">
          <div @click="editContas(row.id)" class="row">
            <div class="col-12">
              <h5 class="badge" :class="row.tipo=='conta'?'bg-success':'bg-danger'">R$
                {{ new String(row.valor).replace('.', ',') }}</h5>
            </div>
            <div class="col-12">
              <h2>{{ row.nome }}</h2>
            </div>
          </div>
          <div class="col-12">
            <button @click="deleteRow(row.id)" class="btn btn-danger float-end m-2">
              <i class="bi bi-trash3-fill"></i>
            </button>
            <button @click="changePago(row.id)" class="btn float-end m-2" :class="row.pago?'btn-success':'btn-danger'">
              <i class="bi bi-currency-exchange"></i>
            </button>

          </div>

        </div>

      </div>
    </div>

  </layout-page>
</template>

<script>
import LayoutPage from "@/components/page/layoutPage.vue";
import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";

import InputForm from "@/components/form/inputForm.vue";


export default {
  name: "DashBoardPage",

  components: {InputForm, LayoutPage},
  data() {
    return {
      nome: '',
      rows: null,
      search: null,
      tenho: 0,
      devo: 0,
      mes: new Date().getMonth() + 1
    }
  },

  methods: {
    async name() {
      let request = new RequestHelper();

      let resposeRequest = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/auth/me', {view: true});
      let nomeCompleto = await resposeRequest.data.name;

      let row = await nomeCompleto.split(' ');
      let helpers = await new Helpers();
      for (let i = 0; i < 10; i++) {
        if (!helpers.empty(row[i])) {
          this.nome = row[i]
          i = 11;
        }
      }


    },
    async list() {


      let dataRequest = {mes: this.mes};
      let requestHelper = new RequestHelper();
      let helpers = new Helpers();

      if (!helpers.empty(this.search)) {
        dataRequest = {
          search: this.search,
          mes: this.mes
        };
      }

      let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contas', dataRequest);
      console.log(dataRow.data)
      if (dataRow.data.length > 0) {
        this.rows = await dataRow.data;
        let tenho = 0;
        let devo = 0;
        for (let i = 0; i < this.rows.length; i++) {
          if (this.rows[i].tipo == 'conta') {
            tenho += parseFloat(this.rows[i].valor);
          } else {
            devo += parseFloat(this.rows[i].valor);
          }
        }
        this.tenho = tenho.toFixed(2);
        this.devo = devo.toFixed(2);

      } else {
        this.rows = [];
        this.tenho = (0.00).toFixed(2);
        this.devo = (0.00).toFixed(2);
      }


    },
    async deleteRow(id) {
      let requestHelper = new RequestHelper();
      await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contas/' + id);
      let mes = document.getElementById('mes');

      this.mes = mes.value;
      this.list();
    },
    editContas(id) {
      location.href = '/contas/' + id + '/edit'
    },
    async changePago(id) {
      let requestHelper = new RequestHelper();
      await requestHelper.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/contas/changePago/' + id, {});

      let mes = document.getElementById('mes');
      this.mes = mes.value;
      this.list();
    },

  },
  created() {
    this.name();
  },
  mounted() {
    let transaction = document.getElementById('list-transactions');
    transaction.style.height = '100%'
    this.list();
    let mes = document.getElementById('mes');
    mes.addEventListener('change', () => {
      this.mes = mes.value;
      this.list()
    })
  }

}


</script>

<style scoped>
@import "toastr/build/toastr.css";
@import "bootstrap-icons/font/bootstrap-icons.min.css";
</style>
<style>
:root {

}

.devo {
  color: #c21a1a;
  font-weight: 600;
  font-size: 100%;
}

.tenho {
  color: #2a5fad;
  font-weight: 600;
  font-size: 100%;
}

.border-left {
  border-left: 1px #e5e7e8 solid;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen,
  Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
  font-weight: 500;
  color: white;
}


.button-circle {
  padding: 0;
  border: none;
  font: inherit;

  outline: 0;
  background-color: transparent;
  cursor: pointer;
  height: 110px;
  width: 110px;
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14),
  0 3px 1px -2px rgba(0, 0, 0, 0.12), 0 1px 5px 0 rgba(0, 0, 0, 0.2);
  border-radius: 100px;
  color: white;
}

.button-circle > span {
  font-size: 100%;
  color: white;
  font-weight: 400 !important;
}

.button-circle > span.button-title {
  font-weight: 800 !important;
}

</style>