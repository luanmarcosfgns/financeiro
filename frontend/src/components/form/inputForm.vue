<template>
    <div v-if="type==='hidden'">
        <input  type="hidden" :name="name" :id="name" :class="name" class="form-control" :value="value" >
    </div>

    <div v-if="type==='blob'" :class="classList">
        <div class="row">
            <div class="col-md-12">
                <label class="p-2" for="nome">{{label}}</label>
            </div>
            <div class="col-md-12 p-4">
                <img :id="'img-'+name" src="@/assets/no-image.png"  width="100">
            </div>
            <div class="col-md-12">
                <input :placeholder="placeholder" type="file" @change="setImageAndValue" data-value="" :name="name" :id="name" :class="name" class="form-control" >
            </div>

        </div>
    </div>


    <div v-if="type==='string'" :class="classList">
        <label class="p-2" for="nome">{{label}}</label>
        <input :placeholder="placeholder" :type="typeInput" :name="name" :id="name" :class="name" class="form-control" v-model="valueInput">
    </div>

    <div v-if="type==='decimal' ||type === 'double'" :class="classList">
        <label class="p-2" for="nome">{{label}}</label>
        <input :placeholder="placeholder" :type="typeInput" :name="name" :id="name" :class="name" class="form-control decimal" v-model="valueInput">
    </div>

    <div v-if="type==='date'" :class="classList">
        <label class="p-2" for="nome">{{label}}</label>
        <input :placeholder="placeholder" type="date" :name="name" :id="name" :class="name" class="form-control" v-model="valueInput">
    </div>

    <div v-if="type==='tinyint'" :class="classList">
        <label class="p-2" for="nome">{{label}}</label>
        <select  :name="name" :id="name" :class="name" class="form-control" v-model="valueInput" >
           <option value="1">Sim</option>
           <option value="0">Não</option>
        </select>
    </div>

    <div v-if="type==='text'" :class="classList">
        <label class="p-2" for="nome">{{label}}</label>
        <textarea :placeholder="placeholder" :name="name" :id="name" :class="name" class="form-control" v-model="valueInput">

        </textarea>
    </div>

    <div v-if="type==='select'" :class="classList" class="form-group">
        <label class="p-2" for="nome">{{label}}</label>
        <select  :name="name" :id="name" :class="name" class="form-control" v-model="valueInput" >
            <option v-if="placeholder!=udefined"  >
                {{this.placeholder}}
            </option>
            <template v-for="item in items" :key="item.id">
                <option :value="item.id" >
                    {{ item.message }}
                </option>
            </template>

        </select>

    </div>

</template>

<script>

import Helpers from "@/services/Helpers";

export default {
    name: "inputForm",
    props: {
        name: String,
        placeholder:String,
        type: String,
        value: String,
        label: String,
        classList: String,
        items: Object
    },
    data(){
        return {
            typeInput:null,
            valueInput:null
        }
    },
    created() {
        this.onReadComponent();
    },
   methods:{
       onReadComponent() {
           let helpers =  new Helpers();
           helpers.empty()

           if (this.type === 'string' || this.type === 'double' || this.type === 'decimal') {
               this.typeInput = 'text'
           }


           if (!helpers.empty(this.value)){
                this.valueInput =  this.value;
           }

       },

       setImageAndValue(){
           let fileInput = document.getElementById(this.name);
           let extention = fileInput.files[0].type;
           let imageDisplay = document.querySelector('#img-'+this.name);
           if(extention.includes('image')){
               let selectedFile = fileInput.files[0];
               let fileReader = new FileReader();
               fileReader.onload = function(event) {
                   imageDisplay.src = event.target.result;
                   fileInput.dataset.value=event.target.result;
               }
               fileReader.readAsDataURL(selectedFile);

           }else{
               imageDisplay.src = require('@/assets/documento.png');
           }

       },

   }
}
</script>

<style scoped>

</style>