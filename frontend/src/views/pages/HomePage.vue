<template>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark navegacao">
        <div class="container">
            <a href="#" class="navbar-brand">
                <img src="@/assets/logo.png" height="50">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu"
                    aria-expanded="false" aria-label="Menu Colapso">
                <span class="navbar-toggler-icon text-light"></span>
            </button>

            <div id="menu" class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto text-light nav-menu">

                    <li class="nav-item ps-3">

                        <a href="#" @click="page('inicio')" class="nav-link text-light font-weight-bold">Inicio</a>
                    </li>
                    <li v-bind:key="categoria" class="nav-item ps-3" v-for="categoria in this.categoriasList">
                        <a href="#" @click="page(categoria.id)"
                           class="nav-link text-light font-weight-bold">{{ categoria.nome }}</a>
                    </li>
                    <li class="nav-item ps-3">
                        <a href="#" @click="page('aboult')" class="nav-link text-light font-weight-bold">Quem Somos</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="container">
            <div class="row">
                <div v-if="inicio===true" class="col-12">
                    <div v-for="sessionsRow in sessionsRows" v-bind:key="sessionsRow">

                        <div class="row" v-if="sessionsRow.type==='carrossel'">
                            <div class="col-12">
                                <div :id="'carrosel_'+sessionsRow.id"
                                     class="carousel slide">

                                    <div class="carousel-indicators">
                                        <button v-for="(sub_sessions, i) in sessionsRow.sub_sessions"
                                                v-bind:key="sub_sessions"
                                                type="button" :data-bs-target="'#carrosel_'+sessionsRow.id"
                                                :data-bs-slide-to="i" class="active" aria-current="true"
                                                :aria-label="'Slide'+i"></button>

                                    </div>
                                    <div class="carousel-inner">
                                        <div v-for="(sub_sessions, i) in sessionsRow.sub_sessions"
                                             v-bind:key="sub_sessions"
                                             class="carousel-item " :data-bs-interval="i+'000'" :class="i==0?'active':''">
                                            <a :href="sub_sessions.link">
                                                <img :src="sub_sessions.image_video" class="d-block w-100" alt="...">
                                            </a>
                                        </div>

                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                            :data-bs-target="'#carrosel_'+sessionsRow.id" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                            :data-bs-target="'#carrosel_'+sessionsRow.id" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="row" v-if="sessionsRow.type==='panel'">
                            <div class="row">
                                <div v-if="sessionsRow.image_video==null"
                                     class="col-10 offset-md-2 text-center mt-5 color-white">
                                    <h2 class="font-weight-400 title-panel ">
                                        {{ sessionsRow.nome }}
                                    </h2>

                                    <p class="text-end p-4 font-descritivo ">
                                        {{ sessionsRow.descritivo }}
                                    </p>
                                </div>
                                <div v-if="sessionsRow.image_video!=null"
                                     class="col-12">
                                    <div class="row p-4">
                                        <div class="col-6">
                                            <h2 style="color: #101084;font-weight: bold" class="font-weight-400 title-panel ">
                                                {{ sessionsRow.nome }}
                                            </h2>

                                            <p class="text-end p-4 font-descritivo ">
                                                {{ sessionsRow.descritivo }}
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <a :href="sessionsRow.link">
                                                <img :src="sessionsRow.image_video" class="d-block w-100" alt="...">
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                <div v-if="sessionsRow.image_video==null" class="col-6">
                                    <img :src="sessionsRow.image_video" alt="">
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                <div v-if="aboult===true" class="col-12">
                  <div class="row">
                      <div class="col-12">
                          <h1></h1>
                      </div>
                  </div>
                </div>
                <div v-if="categoria===true" class="col-12">
                    Categoria
                </div>
            </div>
        </div>

    </main>
    <footer id="sticky-footer" class="flex-shrink-0 py-4 bg-dark text-white-50">
        <div class="container text-center">
            <img src="@/assets/logo.png" height="40">
            <div class="row p-3">
                <div class="col-4">
                    <i class="bi bi-telephone-fill"></i>
                    (65) 99308-1672
                </div>
                <div class="col-4">
                    <i class="bi bi-geo-alt-fill"></i>
                    Edificio CEVAG, Av. Castelo Branco, nº 325 - 1º Andar, Sala 14 Centro Sul, Várzea Grande - MT - 78110-002.
                </div>
                <div class="col-4">
                    <i class="bi bi-envelope-at-fill"></i>
                    comercial@facilitacorretoradeseguros.com.br
                </div>
            </div>

        </div>

    </footer>


</template>

<script>
import axios from "axios";

export default {
    name: "HomePage",
    data() {
        return {
            inicio: true,
            categoria: false,
            categoriaRow: null,
            sessionsRows: null,
            categoriasList: null,
            aboult: false,
        }
    },
    methods: {
        page(id) {
            if (id == 'inicio') {
                this.inicio = true;
                this.categoria = false;
                this.aboult = false;
            } else if (id == 'aboult') {
                this.inicio = false;
                this.categoria = false;
                this.aboult = true;
            } else {
                console.log('categoria')
            }
        },
        listCategoria() {
            console.log(process.env.VUE_APP_API_HOST_NAME)
            axios.get(process.env.VUE_APP_API_HOST_NAME + '/api/site/categorias/list/' + this.$route.params.hash).then((response) => {
                this.categoriasList = response.data
            })
        },
        listSessions() {
            axios.get(process.env.VUE_APP_API_HOST_NAME + '/api/site/sessions/list/' + this.$route.params.hash).then((response) => {
                this.sessionsRows = response.data
                console.log(this.sessionsRows)
            })
        }

    }
    , mounted() {
        this.listCategoria();
        this.listSessions();
    },

}
</script>

<style scoped>
main {
    margin-top: 77px;
}
body{

}

.font-weight-bold {
    font-weight: bold;
}

.font-weight-100 {
    font-weight: 100;
}

.font-weight-200 {
    font-weight: 200;
}

.font-weight-300 {
    font-weight: 300;
}

.font-weight-350 {
    font-weight: 300;
}

.font-weight-400 {
    font-weight: 400;
}

.color-white {
    color: white;
}

.title-panel {
    font-size: 300%;
}

.font-descritivo {
    font-size: 150%;
}
</style>