<template>


    <div class="row">
        <div class="col-12 ps-4 pt-3 ">
            <div class="float-start">
                <h5> Perguntas</h5>

            </div>

        </div>

    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <div class="w-100">
                    <input id="search" class="form-control" @change="list()" placeholder="Digite sua pesquisa"
                           type="text" v-model="search">
                </div>
            </tr>
            <tr>

                <th>#</th>
                <th>Enunciado</th>
                <th>Respostas</th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="row in rows" :key="row.id">

                <td>{{ row.ordem }}</td>
                <td>{{ row.enunciado }}</td>
                <td>{{ row.resposta }}</td>



            </tr>
            <tr v-if="rows==null">
                <td colspan="5" class="text-center"> Não há dados</td>
            </tr>
            </tbody>
        </table>
    </div>


</template>
<script>

import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";


export default {
    name: "ListPerguntas",
    components: {},
    props: {
        venda_id: Number
    },
    data() {
        return {
            rows: null,
            search: null
        }
    },
    methods: {
        async list() {
            console.log(this.venda_id)

            if (this.venda_id == null) {
                return false
            }
            let dataRequest = {
                venda_id: this.venda_id,

            };
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    search: this.search,
                    venda_id: this.venda_id,
                };
            }

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas/list', dataRequest);

            if (dataRow?.data?.data) {
                this.rows = dataRow.data.data;

            }


        },
        async deleteRow(id) {
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/perguntas/' + id);
            if (dataRow.data.success) {
                this.list();
                toastr.success('Apagado com sucesso');
            } else {
                toastr.error('Houve um problema ao apagar');
            }
        }


    },
    mounted() {
        this.list();

    }
}

</script>

<style scoped>
@import "toastr/build/toastr.css";
@import "bootstrap-icons/font/bootstrap-icons.min.css";
</style>
<style>
.close {
    color: #aaaaaa;
    float: right !important;
    text-align: right;
    font-size: 28px !important;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>