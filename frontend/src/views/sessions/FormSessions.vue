<template>
    <input-form class-list="col-12" type="string" label="Nome " value="" name="nome"/>
    <input-form class-list="col-12" type="text" label="Descritivo " value="" name="descritivo"/>
    <input-form class-list="col-12" type="text" label="Link " value="" name="link"/>
    <input-form class-list="col-12" type="blob" label="Imagem ou Video " value="" name="image_video"/>
    <input-form  class-list="col-12" type="select" :items="sessions" label="Sessão Pai "
                value="" name="parent_id"/>


</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "FormSessions",
    components: {InputForm},
    data() {
        return {sessions: null}
    },
    methods: {
        async getSessions() {
            let request = new RequestHelper();
            this.sessions = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/sessions/list', {});
            this.sessions = await this.sessions.data;

        },


    },
    created() {
        this.getSessions();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>