<template>
    <header>
        <nav class="navbar  bg-body-tertiary p-2" style="z-index: 1;">


            <a aria-controls="offcanvasScrolling" class="navbar-brand  " data-bs-target="#sideBar"
               data-bs-toggle="collapse" href="#">
                <svg class="bi bi-list" fill="currentColor" height="16" style="color: #1a202c"
                     viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"
                          fill-rule="evenodd"/>
                </svg>
            </a>



            <a class="float-end p-2" href="/logout">
                <svg class="bi bi-box-arrow-right" fill="currentColor" height="16" style="color: #1a202c"
                     viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"
                          fill-rule="evenodd"/>
                    <path d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"
                          fill-rule="evenodd"/>
                </svg>
            </a>

        </nav>
    </header>

    <div class="container">




        <div class="container mt-5">
            <div class="row">
                <div class="col-12">


                    <aside>
                        <div id="sideBar"
                             aria-labelledby="staticBackdropLabel" class="offcanvas offcanvas-start overflow-auto"
                             data-bs-backdrop="static"
                             style="top:56px; z-index: 2; width: 200px; position: absolute">
                            <ul class="nav flex-column ">

                                <li class="nav-item p-2  border border-1 ">
                                    <router-link aria-current="page" class="nav-link active" to="/painel">
                                        <svg class="bi bi-bar-chart-line-fill" fill="currentColor" height="16"
                                             viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z"/>
                                        </svg>
                                        Painel
                                    </router-link>
                                </li>
                                <li class="nav-item p-2  border border-1">

                                    <router-link aria-current="page" class="nav-link active" to="/contatos/index">
                                        <svg class="bi bi-file-person-fill" fill="currentColor" height="16"
                                             viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4c2.623 0 4.146.826 5 1.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-1.245C3.854 11.825 5.377 11 8 11z"/>
                                        </svg>
                                        Contatos
                                    </router-link>
                                </li>
                                <li class="nav-item p-2  border border-1">
                                    <router-link aria-current="page" class="nav-link active" to="/categorias/index">
                                        <svg class="bi bi-ticket-detailed-fill" fill="currentColor" height="16"
                                             viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5Zm4 1a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5Zm0 5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5ZM4 8a1 1 0 0 0 1 1h6a1 1 0 1 0 0-2H5a1 1 0 0 0-1 1Z"/>
                                        </svg>
                                        Categorias
                                    </router-link>
                                </li>

                                <li class="nav-item p-2  border border-1">

                                    <router-link aria-current="page" class="nav-link active" to="/servicos/index">
                                        <svg class="bi bi-file-person-fill" fill="currentColor" height="16"
                                             viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm-3 4c2.623 0 4.146.826 5 1.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-1.245C3.854 11.825 5.377 11 8 11z"/>
                                        </svg>
                                        Serviços
                                    </router-link>
                                </li>
                                <li class="nav-item p-2  border border-1">
                                    <router-link aria-current="page" class="nav-link active" to="/cotations/index">
                                        <svg class="bi bi-coin" fill="currentColor" height="16" viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                        </svg>
                                        Cotações
                                    </router-link>
                                </li>
                                <li class="nav-item p-2  border border-1">
                                    <router-link aria-current="page" class="nav-link active" to="/vendas/index">
                                        <svg class="bi bi-coin" fill="currentColor" height="16" viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9H5.5zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518l.087.02z"/>
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11zm0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"/>
                                        </svg>
                                        Vendas
                                    </router-link>
                                </li>



                                <li class="nav-item p-2  border border-1">

                                    <router-link aria-current="page" class="nav-link active" to="/users/index">
                                        <svg class="bi bi-file-earmark-lock2-fill" fill="currentColor" height="16"
                                             viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 7a1 1 0 0 1 2 0v1H7V7z"/>
                                            <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM10 7v1.076c.54.166 1 .597 1 1.224v2.4c0 .816-.781 1.3-1.5 1.3h-3c-.719 0-1.5-.484-1.5-1.3V9.3c0-.627.46-1.058 1-1.224V7a2 2 0 1 1 4 0z"/>
                                        </svg>
                                        Usuários
                                    </router-link>
                                </li>
                                <li class="nav-item p-2  border border-1">
                                    <router-link aria-current="page" class="nav-link active" to="/sessoes/index">
                                        <svg class="bi bi-ticket-detailed-fill" fill="currentColor" height="16"
                                             viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5Zm4 1a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5Zm0 5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5ZM4 8a1 1 0 0 0 1 1h6a1 1 0 1 0 0-2H5a1 1 0 0 0-1 1Z"/>
                                        </svg>
                                        Sessões
                                    </router-link>
                                </li>
                                <li class="nav-item p-2  border border-1">
                                    <a aria-current="page" class="nav-link active" href="#" @click="goConfig">
                                        <svg class="bi bi-gear-fill" fill="currentColor" height="16" viewBox="0 0 16 16"
                                             width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                        </svg>
                                        Configurações
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </aside>
                    <div>

                    </div>


                </div>

                <div class="col-12" style="z-index: 0;">
                    <div class="page-wrapper bg-gra-02 p-t-130  font-poppins">
                        <div class="wrapper wrapper--w680 p-4 ">
                            <div class="card card-4">
                                <slot></slot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";

export default {
    name: "layoutPage",
    methods: {
        async goConfig() {
            let request = new RequestHelper();
            let resposeRequest = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/auth/me', {view: true});
            let business_id = await resposeRequest.data.business_id;
            let helper = new Helpers();
            if (helper.empty(business_id)) {
                location.href = '/business/create';
            } else {
                location.href = '/business/' + business_id + '/edit';
            }

        }
    }
}
</script>

<style scoped>
body {
    padding: 4px;
}
.nav-link{
    color: #3baaa1 !important;
    font-weight: bold;
}
</style>