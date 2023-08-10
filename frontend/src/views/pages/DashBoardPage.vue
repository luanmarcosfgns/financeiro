<template>
    <layout-page>
        <div class="card-header">
            <img src="@/assets/logo.png" width="250">
        </div>
        <div class="card-body">
            <h4 class="p-3">Bem Vindo! {{ nome }}</h4>
        </div>
    </layout-page>
</template>

<script>
import LayoutPage from "@/components/page/layoutPage.vue";
import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";


export default {
    name: "DashBoardPage",
    components: {LayoutPage},
    data() {
        return {nome: ''}
    },
    methods: {
        async name() {
            let request = new RequestHelper();

            let resposeRequest = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/auth/me', {});
            let nomeCompleto = await resposeRequest.data.name;
            let row = await nomeCompleto.split(' ');
            let helpers = await new Helpers();
            for (let i=0;i<10; i++){
                if (!helpers.empty(row[i])) {
                    this.nome =row[i]
                    i = 11;
                }
            }



        }

    },
    created() {
       this.name();

    }

}


</script>

<style scoped>

</style>