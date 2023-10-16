<template>
  <header>
    <nav class="navbar  bg-body-tertiary p-2" style="z-index: 1;">


      <a aria-controls="offcanvasScrolling" class="navbar-brand  " data-bs-target="#sideBar"
         data-bs-toggle="collapse" href="#">

          <img src="@/assets/logo.png" width="50">

      </a>



      <a class="float-end p-2" href="/logout">
        <svg class="bi bi-box-arrow-right" fill="currentColor" height="16" style="color: #1a202c"
             viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
          <path
              d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"
              fill-rule="evenodd"/>
          <path
              d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"
              fill-rule="evenodd"/>
        </svg>
      </a>

    </nav>
  </header>

  <div class="container">


    <div class="container mt-3">
      <div class="row">
        <div class="col-12" style="z-index: 0;">
              <div class="card card-12">
                <slot></slot>
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
  data() {
    return {
      countNotification: 0,
      notifications: 0
    }
  },
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

    },
    popover(id) {
      let popover = document.getElementById(id);
      if (popover.classList.contains('d-none')) {
        document.getElementById(id).classList.remove('d-none');
      } else {
        document.getElementById(id).classList.add('d-none');
      }

    },
    async pullNotificationsInINterval() {
      // let request = new RequestHelper();
      // let i = 0;
      // setInterval(async ()=>{
      //   let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/notify/list', {});
      //
      //   if (i > 0) {
      //     if(this.countNotification!=response.data.length){
      //       this.beep()
      //       this.solicitarPermissaoParaNotificacoes().then((permissaoConcedida)=>{
      //         if (permissaoConcedida) {
      //           // Criar uma notificação
      //           this.criarNotificacao("Facilita Corretora", "Você tem uma nova Notificação!", );
      //         }
      //       });
      //
      //     }
      //   }
      //   this.countNotification = response.data.length;
      //   this.notifications = response.data;
      //   i++
      // },10000)


    },
    beep() {
     const sound = require('@/assets/notifications.mp3');
        // Crie um elemento de áudio
        var audio = new Audio(sound); // Substitua pelo caminho do seu arquivo de áudio

        // Reproduz o som
        audio.play();

    },
    solicitarPermissaoParaNotificacoes() {
      if ("Notification" in window) {
        // Verifica se as notificações são suportadas pelo navegador

        return Notification.requestPermission().then(function (permission) {
          return permission === "granted";
        });
      } else {
        console.warn("Notificações não são suportadas neste navegador.");
        return Promise.resolve(false);
      }
    },
    criarNotificacao(titulo, corpo, icone) {
      if (Notification.permission === "granted") {
        // Se a permissão foi concedida, crie uma notificação
        var options = {
          body: corpo,
          icon: icone
        };

        var notification = new Notification(titulo, options);

        // Lidar com eventos de clique na notificação
        notification.onclick = function () {
          // Faça algo quando a notificação for clicada
        };
      } else if (Notification.permission === "denied") {
        console.warn("Permissão para notificações negada pelo usuário.");
      } else {
        console.warn("Permissão para notificações não foi concedida.");
      }
    }

  },
  mounted() {
    this.pullNotificationsInINterval();
  }
}
</script>

<style scoped>
body {
  padding: 2px;
}

.nav-link {
  color: #3baaa1 !important;
  font-weight: bold;
}

.custom-popover {

  position: absolute;
  background-color: #fff;
  border: 0px solid #ccc;
  padding: 10px;
  z-index: 9999;
  top: 100%;
  left: 45%;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;


}

.popover-header {
  font-weight: bold;
  border-bottom: 1px solid #ccc;
  text-align: center;
}

.popover-body {
  font-size: 13px;
  padding: 5px;
  max-width: 200px;
  word-break: normal;
  border-bottom: 1px solid #ccc;


}
.popover-body>a{
  text-decoration: none
}
</style>