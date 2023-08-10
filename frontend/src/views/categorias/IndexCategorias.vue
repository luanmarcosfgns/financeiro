<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-md-6 ps-4 ">
                    <h5> Categorias</h5>
                </div>
                <div class="offset-4 col-md-2  float-end">
                    <button-widget cor="azul" tamanho="M" href="./create">
                        Adcionar
                    </button-widget>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table>
                <tbody>
                    <tr>
                        <td>#</td>
                        <td>Nome</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </layout-page>
</template>

<script>
import LayoutPage from "@/components/page/layoutPage.vue";
import ButtonWidget from "@/components/widget/buttonWidget.vue";

export default {
    name: "IndexCategorias",
    components: {ButtonWidget, LayoutPage}
}
</script>

<style scoped>

</style>