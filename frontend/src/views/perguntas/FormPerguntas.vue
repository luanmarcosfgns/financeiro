<template>

    <input-form class-list="col-md-12" type="text" label="Enunciado " value="" name="enunciado"/>
    <input-form class-list="col-md-12" type="json" label="Opcoes " value="" name="opcoes"/>
    <input-form class-list="col-md-12" type="int" label="Ordem " value="" name="ordem"/>
    <input-form placeholder="Selecione Tipo Resposta " class-list="col-md-12" :class="visible_tipo_resposta" type="select"
                :items="[{id:'multipla',message:'multipla',},{id:'unica',message:'unica',},{id:'descritiva',message:'descritiva',},{id:'inteira',message:'inteira',},{id:'decimal',message:'decimal',},{id:'datada',message:'datada',},]"
                label="Tipo Resposta " value="" name="tipo_resposta"/>

</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormPerguntas",
    components: {InputForm},
    data() {
        return {
            perguntas: null,
            visible_tipo_resposta:null
        }
    },
    methods: {
        async getPerguntas() {
            let request = new RequestHelper();
            this.perguntas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas/list', {});
            this.perguntas = await this.perguntas.data;

        }

    },
    created() {
        this.getPerguntas();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>