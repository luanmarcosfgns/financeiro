<template>
  <div v-if="type==='hidden'">
    <input type="hidden" :name="name" :id="name" :class="name" class="form-control" :value="value">
  </div>
  <div v-if="type==='blob'" :class="classList">
    <div class="row">
      <div class="col-12">
        <label class="p-2" for="nome">{{ label }}</label>
      </div>
      <div class="col-12 p-4">
        <img alt="Quando Não há imagem" :id="'img-'+name" src="@/assets/no-image.png" width="300">
      </div>
      <div class="col-12">
        <input :placeholder="placeholder" type="file" @change="setImageAndValue" data-value="" :name="name"
               :id="name" :class="name" class="form-control">
      </div>

    </div>
  </div>
  <div v-if="type==='string'" :class="classList">
    <label class="p-2" for="nome">{{ label }}</label>
    <input :placeholder="placeholder" type="text" :name="name" :id="name" :class="name" class="form-control"
           v-model="valueInput">
  </div>
  <div v-if="type==='decimal' ||type === 'double'" :class="classList">
    <label class="p-2" for="nome">{{ label }}</label>
    <input :placeholder="placeholder" type="number" :name="name" :id="name" :class="name"
           class="form-control decimal" v-model="valueInput">
  </div>
  <div v-if="type==='date'" :class="classList">
    <label class="p-2" for="nome">{{ label }}</label>
    <input :placeholder="placeholder" type="date" :name="name" :id="name" :class="name" class="form-control"
           v-model="valueInput">
  </div>
  <div v-if="type==='tinyint'" :class="classList">
    <label class="p-2" for="nome">{{ label }}</label>
    <select :name="name" :id="name" :class="name" class="form-control" v-model="valueInput">
      <option value="1">Sim</option>
      <option value="0">Não</option>
    </select>
  </div>
  <div v-if="type==='text'" :class="classList">
    <label class="p-2" for="nome">{{ label }}</label>
    <textarea :placeholder="placeholder" :name="name" :id="name" :class="name" class="form-control"
              v-model="valueInput">

        </textarea>
  </div>
  <div v-if="type==='int' ||type === 'bigint'" :class="classList">
    <label class="p-2" for="nome">{{ label }}</label>
    <input step="0.00" :placeholder="placeholder" @input="validateInt" @keyup="validateInt" @keydown="validateInt" type="number" :name="name" :id="name" :class="name"
           class="form-control decimal" v-model="valueInput">
  </div>
  <div v-if="type==='json'" :class="classList">
    <label class="p-2" for="nome">{{ label }}</label>
    <div class="row">
      <div class="col-10">
        <input :placeholder="placeholder" type="text" :id="'search'+name" :class="'search'+name"
               class="form-control">
        <input type="hidden" :name="name" :id="name" :class="name" v-model="valueInput">
      </div>
      <div class="col-2">
        <button @click="addRowSelectJson" class="btn btn-primary">+</button>
      </div>
      <div class="col-12">
        <ol>
          <li class="p-2" v-for="(row,i) in rows" v-bind:key="row">

            <div class="btn-group ">
              <button class="btn btn-danger btn-xsm">
                <input :id="this.name+'_options_'+i" :value="row" @change="editRowJson(i)">
              </button>
              <button class="btn btn-danger btn-xsm" @click="deleteRowJson(i)">
                <i class="bi bi-trash2-fill"></i>
              </button>
            </div>

          </li>
        </ol>

      </div>
    </div>

  </div>
  <div v-if="type==='select'" :class="classList" class="form-group">
    <label class="p-2" for="nome">{{ label }}</label>
    <select :name="name" :id="name" :class="name" class="form-control" v-model="valueInput">
      <option v-if="placeholder!=udefined">
        {{ this.placeholder }}
      </option>
      <template v-for="item in items" :key="item.id">
        <option :value="item.id">
          {{ item.message }}
        </option>
      </template>

    </select>
  </div>
  <div v-if="type==='select2'" :class="classList" class="form-group">

    <div class="row">
      <div class="col-12">
        <label class="p-2" :for="name">{{ label }}</label>
      </div>
      <div class="col-3">

        <input placeholder="Digite o código" type="number" :name="name" :id="name"
               @input="setIdSelect2()"
               @change="setIdSelect2()"
               :class="name"
               class="form-control decimal" v-model="valueInput">
      </div>
      <div class="col-9">
        <input @input="readClickSelect2" class="form-control dropdown-toggle" type="text"
               placeholder="Ou digite a pesquisa"
               :name="'search-'+name"
               :id="'search-'+name">
        <div class="row">
          <div class="col-12">
            <ul class="dropdown-item-select2" :id="'dropdown-'+name">
              <li v-for="row in rows" :key="row" @click="setLabelSelect2(row.code)">
                {{ row.label }}
              </li>
            </ul>
          </div>
        </div>


      </div>
    </div>
  </div>
</template>

<script>

import Helpers from "@/services/Helpers";
import RequestHelper from "@/services/RequestHelper";


export default {
  name: "inputForm",
  props: {
    name: String,
    url: String,
    placeholder: String,
    type: String,
    value: String,
    label: String,
    classList: String,
    items: Object
  },
  data() {
    return {
      valueInput: null,
      rows: null
    }
  },
  created() {
    this.onReadComponent();


  },
  methods: {
    onReadComponent() {
      let helpers = new Helpers();
      helpers.empty()

      if (!helpers.empty(this.value)) {
        this.valueInput = this.value;
      }

    },
    setImageAndValue() {
      let fileInput = document.getElementById(this.name);

      let extention = fileInput.files[0].type;
      let imageDisplay = document.querySelector('#img-' + this.name);
      let selectedFile = fileInput.files[0];
      let fileReader = new FileReader();
      imageDisplay.src = require('@/assets/documento.png');


      fileReader.onload = (event) => {
        if (extention.includes('image')) {
          imageDisplay.src = event.target.result;
        }
        fileInput.dataset.value = event.target.result;
      }
      fileReader.readAsDataURL(selectedFile);


    },
    addRowSelectJson() {
      let row = document.getElementById('search' + this.name).value;
      if (this.rows == null) {
        this.rows = [];
      }
      this.rows.push(row)
      this.valueInput = JSON.stringify(this.rows)
      this.valueInput = this.clearStringJson(this.valueInput);
      document.getElementById('search' + this.name).value = '';
    },
    async readRowSelectJson() {

      setTimeout(() => {
        let value = document.getElementById(this.name).value;
        let helper = new Helpers();
        if (!helper.empty(value)) {
          this.valueInput = value;
          this.valueInput = this.clearStringJson(this.valueInput);
          this.listRowJson(this.valueInput);
        }

      }, 1000)

    },
    listRowJson(list) {
      this.rows = this.clearStringJson(list).split(',');
    },
    deleteRowJson(i) {
      this.rows.splice(i, 1);
      this.valueInput = JSON.stringify(this.rows)
      this.valueInput = this.clearStringJson(this.valueInput);

    },
    editRowJson(i) {
      this.rows[i] = document.getElementById(this.name + '_options_' + i).value;
      this.valueInput = JSON.stringify(this.rows)
      this.valueInput = this.clearStringJson(this.valueInput);
      console.log(document.getElementById(this.name).value)
    },
    clearStringJson(value) {
      let helper =  new Helpers();
     value =  helper.decodeUnicode(value);
      return value
          .replaceAll('[', '')
          .replaceAll(']', '')
          .replaceAll('"', '')
          .replaceAll('\\', '')
          .replaceAll("'", '');
    },
    async readClickSelect2() {
      if (this.type === 'select2') {
        document.getElementById('dropdown-' + this.name).classList.add('d-none');
        let request = new RequestHelper();

        var searchTimeout;
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(async () => {
          let search = document.getElementById('search-' + this.name).value;
          let payload = {
            search: search,
          };
          if (search != undefined) {
            payload = {
              search: search
            }
          }

          let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + this.url, payload);

          if (response.data.length == 1) {
            document.getElementById('search-' + this.name).value = response.data[0].label
            document.getElementById(this.name).value = response.data[0].code
            document.getElementById('dropdown-' + this.name).classList.add('d-none');
          } else if (response.data.length > 1) {
            this.rows = response.data;
            document.getElementById('dropdown-' + this.name).classList.remove('d-none');
          } else {
            document.getElementById('dropdown-' + this.name).classList.add('d-none');
          }
        });

      }
    },
    async setIdSelect2() {
      let id = this.valueInput;
      document.getElementById('dropdown-' + this.name).classList.add('d-none');
      let payload = {
        id: id,
      }
      let request = new RequestHelper();
      let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + this.url, payload);

      if (!new Helpers().empty(response?.data?.code)) {
        document.getElementById('search-' + this.name).value = response.data.label;
        document.getElementById(this.name).value = response.data.code;
      }

      return true;
    },
    async setLabelSelect2(id) {
      let payload = {
        id: id,
      }
      let request = new RequestHelper();
      let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + this.url, payload);

      if (!new Helpers().empty(response?.data?.code)) {
        document.getElementById('search-' + this.name).value = response.data.label;
        document.getElementById(this.name).value = response.data.code;
      }
      document.getElementById('dropdown-' + this.name).classList.add('d-none');

      return true;
    },
    mountSelect2() {
      if (this.type === 'select2') {

        setTimeout(() => {
          let id = document?.getElementById(this.name)?.value;
          let helper = new Helpers();
          if (!helper.empty(id)) {
            this.setLabelSelect2(id);
          }

        }, 2000)

      }


    },
    validateInt() {
      this.valueInput = new String(this.valueInput).replaceAll(',','').replaceAll('.','')
    }

  },
  mounted() {
    this.mountSelect2()
    if (this.type == 'json') {
      this.readRowSelectJson();

    }
    if (this.type == 'int') {
      this.validateInt();

    }
  }


}
</script>

<style scoped>
.dropdown-item-select2 {
  list-style: none;

  position: absolute;


}

.dropdown-item-select2 li {
  padding: 8px;
  border-bottom: 0.1px solid #dee2e6;
  border-left: 0.1px solid #dee2e6;
  border-right: 0.1px solid #dee2e6;
  overflow-wrap: break-word;
  width: 210px;
  background-color: white;


}

.dropdown-item-select2 li:hover {

  background-color: rgba(166, 177, 197, 0.98);
  cursor: pointer;


}

.form-control {
  border-top-color: white !important;
  border-left-color: white !important;
  border-right-color: white !important;
  border-radius: 0px;
}

.btn-xsm {
  --bs-btn-padding-y: 1px;
  --bs-btn-padding-x: 15px;
  --bs-btn-font-size: 15px
}
</style>