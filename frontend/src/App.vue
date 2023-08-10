<template>
    <div>
        <loading-page></loading-page>
        <router-view></router-view>
    </div>

</template>

<script>
import LoadingPage from "@/components/page/loadingPage.vue";

export default {
    name: 'App',
    components: {LoadingPage},

}
</script>
<style>
.toast-error {
    background-color: red !important;
}

.toast-success {
    background-color: greenyellow !important;
}

.toast-info {
    background-color: dodgerblue !important;
}
</style>