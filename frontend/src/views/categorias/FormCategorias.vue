<template>
        <input-form class-list="col-md-12"  type="string" label="Nome" value="" name="nome"/>
        <input-form class-list="col-md-12" type="text" label="Descritivo" value="" name="descritivo"/>
        <input-form placeholder="Selecione categorias" class-list="col-md-12" type="select" :items="categorias" label="Categorias" value=""
                    name="parent_id"/>
</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormCategorias",
    components: {InputForm},
    data() {
        return {categorias: null}
    },
    methods:{
         async getCategorias(){
            let request =  new RequestHelper();
            this.categorias = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/categorias/list',{});
             this.categorias =  await this.categorias.data;

        },


    },
    created() {
        this.getCategorias();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>