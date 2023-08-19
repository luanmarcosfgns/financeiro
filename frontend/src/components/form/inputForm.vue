<template>
    <div v-if="type==='string'" :class="classList">
        <label class="p-2" for="nome">{{label}}</label>
        <input :placeholder="placeholder" :type="typeInput" :name="name" :id="name" :class="name" class="form-control" v-model="valueInput">
    </div>
    <div v-if="type==='text'" :class="classList">
        <label class="p-2" for="nome">{{label}}</label>
        <textarea :placeholder="placeholder" :name="name" :id="name" :class="name" class="form-control" v-model="valueInput">

        </textarea>
    </div>
    <div v-if="type==='select'" :class="classList">
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

           if (this.type === 'string') {
               this.typeInput = 'text'
           }
           if (!helpers.empty(this.value)){
                this.valueInput =  this.value;
           }

           console.log(this.items);

       }
   }
}
</script>

<style scoped>

</style>