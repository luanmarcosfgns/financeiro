<template>
    <div class="row">

        <div class="col-10 p-2">
            <div class="row">
                <input-form class-list="col-12" label="Link gerado" type="string" name="link-generated"
                            value=""></input-form>
            </div>
        </div>

        <div class="col-2 pt-lg-5">
            <button @click="copy()" class="btn btn-success">
                <i class="bi bi-clipboard-fill"></i>
            </button>
        </div>

    </div>
</template>

<script>
import InputForm from "@/components/form/inputForm.vue";


export default {
    name: "LinkGenerate",
    components: {InputForm},
    methods: {
        copy() {
            let link = document.getElementById('link-generated');
            // Seleciona o texto no campo de texto
            link.select();

            // Copia o texto para a área de transferência
            document.execCommand("copy");

            // Deseleciona o campo de texto (opcional)
            link.blur();
        }

    }
}
</script>

<style scoped>

</style>