<template>

    <input-form class-list="col-12" type="text" label="Enunciado " value="" name="enunciado"/>
    <input-form  v-if="displayOptions" class-list="col-12 opcoes_component" type="json" label="Opcoes " value="" name="opcoes"/>
    <input-form class-list="col-12" type="int" label="Ordem " value="" name="ordem"/>
    <input-form class-list="col-12" :class="visible_tipo_resposta" type="select"
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
            visible_tipo_resposta:null,
            visible_opcoes:null
        }
    },
    methods: {
        async getPerguntas() {
            let request = new RequestHelper();
            this.perguntas = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas/list', {});
            this.perguntas = await this.perguntas.data;

        },
        displayOptions(){
            let tipo_resposta = document.getElementById('tipo_resposta');
            if(tipo_resposta.value==='unica' || tipo_resposta.value==='multipla'  ){
              document.getElementsByClassName('opcoes_component')[0].classList.remove('d-none')
            }else{
                document.getElementsByClassName('opcoes_component')[0].classList.add('d-none')
                this.visible_opcoes =  false;
            }
        }

    },
    created() {
        this.getPerguntas();

    },
    mounted() {
        this.displayOptions();
        document.getElementById('tipo_resposta').addEventListener('change',()=>{
            this.displayOptions()
        })
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>