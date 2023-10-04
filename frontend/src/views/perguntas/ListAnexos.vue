<template>
  <div class="row">
    <div class="col-3 p-3" style="min-width: 200px " v-for="anexo in anexos" v-bind:key="anexo">
      <div class="row">
        <div class="col-12">
          <button @click="downloadBase64(anexo.anexo,anexo.nome)" class="btn btn-success w-100">
            {{ anexo.nome }}
            <br>
            <i class="bi bi-file-earmark-bar-graph-fill" style="height: 100px"></i>
            <br>
            <span class="badge rounded-pill text-bg-primary vendedor_d_none " style="font-size: 50%">Comissão Total: R$ {{ calculaPorcentagem(anexo.valor_premio, anexo.comissao) }}</span>
            <span class="badge rounded-pill text-bg-primary vendedor_d_none" style="font-size: 50%">
                            Taxa Franquiadora: R$ {{ calculaPorcentagem(anexo.valor_premio, anexo.porcentagem_franquiadora) }}
                        </span>
            <span class="badge rounded-pill text-bg-danger"
                  style="font-size: 50%">Comissão Vendedor: R$ {{ calculaPorcentagem(anexo.valor_premio, anexo.porcentagem_vendedor) }}</span>
            <span class="badge rounded-pill text-bg-primary vendedor_d_none"
                  style="font-size: 50%">Corretora: R$ {{ calculaPorcentagem(anexo.valor_premio, anexo.porcentagem_corretora) }}</span>
            <span class="badge rounded-pill text-bg-primary "
                  style="font-size: 50%">Valor Prêmio: R$ {{ calculaPorcentagem(anexo.valor_premio, 100) }}</span>
            <span v-if="anexo.melhor_opcao" class="badge rounded-pill text-bg-warning " style="font-size: 50%">(Recomendado)</span>

          </button>
        </div>
        <div class="col-12 pt-3">
          <button @click="deleteCotations(anexo.id)" class="btn btn-danger vendedor_d_none "
                  style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: .5rem; font-size: 13px">excluir
          </button>
          <button :class="anexo.selecionado==1?'btn-success':'btn-primary'" @click="selectCotations(anexo.id)"
                  class="btn  ms-1"
                  style="--bs-btn-padding-y: 3px; --bs-btn-padding-x: .5rem; font-size: 13px">
            {{ anexo.selecionado == 0 ? 'selecionar' : 'Selecionado' }}
          </button>
          <button style="--bs-btn-padding-y: 1px; --bs-btn-padding-x: .5rem; font-size: 13px; border-radius: 10px"  type="button" class="btn btn-info m-1" @click="popover(anexo.id)">
            i
          </button>
          <div :id="'customPopover_'+anexo.id" class="custom-popover d-none">
            <div class="popover-header">Descrição</div>
            <div class="popover-body">{{ anexo.descritivo }}</div>
          </div>
        </div>
      </div>

    </div>
    <div style="min-width: 195px " class="col-3 p-3 vendedor_d_none">
      <a :href="'/anexos_vendas/create/'+venda_id" class="btn btn-success">

        <i class="bi bi-plus " style="height: 100px"></i>
      </a>
    </div>
  </div>
</template>

<script>
import RequestHelper from "@/services/RequestHelper";

export default {
  name: "ListAnexos",
  props: {
    venda_id: String
  },
  methods: {
    popover(id) {
      let popover =  document.getElementById('customPopover_' + id);
      if(popover.classList.contains('d-none')){
        document.getElementById('customPopover_' + id).classList.remove('d-none');
      }else{
        document.getElementById('customPopover_' + id).classList.add('d-none');
      }

    },
    downloadBase64(base64Data, fileName) {
      // Obter o tipo MIME a partir dos dados Base64
      const mimeType = base64Data.split(':')[1].split(';')[0];

      // Decodificar a string Base64 em um array de bytes
      const byteCharacters = atob(base64Data.split(',')[1]);
      const byteNumbers = new Array(byteCharacters.length);
      for (let i = 0; i < byteCharacters.length; i++) {
        byteNumbers[i] = byteCharacters.charCodeAt(i);
      }
      const byteArray = new Uint8Array(byteNumbers);

      // Criar um objeto Blob com os dados decodificados e o tipo MIME
      const blob = new Blob([byteArray], {type: mimeType});

      // Obter a extensão do arquivo a partir do tipo MIME
      const fileExtension = mimeType.split('/')[1];


      // Definir o nome de arquivo como o nome fornecido ou o nome padrão
      const finalFileName = fileName + '.' + fileExtension

      // Criar um URL do objeto Blob
      const blobUrl = URL.createObjectURL(blob);

      // Criar um link de download e acionar o clique nele para iniciar o download
      const a = document.createElement('a');
      a.href = blobUrl;
      a.download = finalFileName;
      a.style.display = 'none';
      document.body.appendChild(a);
      a.click();

      // Remover o link após o download
      document.body.removeChild(a);

      // Liberar o URL do objeto Blob
      URL.revokeObjectURL(blobUrl);
    },
    async deleteCotations(id) {
      let request = new RequestHelper();
      await request.deleteAuth(process.env.VUE_APP_API_HOST_NAME + '/api/anexos_vendas/' + id)
      this.list()
    },
    async list() {
      let request = new RequestHelper();
      let rows = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + '/api/anexos_vendas', {id: this.venda_id})
      this.anexos = await rows.data.data
      if (this.anexos.length == 0) {
        this.anexos = false;
      }
    },
    async selectCotations(id) {
      let request = new RequestHelper();
      await request.postAuth(process.env.VUE_APP_API_HOST_NAME + '/api/anexos_vendas/' + id, {
        "_method": "PUT",
        selecionado: true
      })
      this.list()
    },
    calculaPorcentagem(valor, porcentagem) {
      let total = (porcentagem / 100) * valor;
      return new String(total.toFixed(2)).replace('.', ',');
    }
  },
  data() {
    return {
      anexos: null
    }
  },
  mounted() {
    this.list();

  }
}
</script>

<style scoped>
.bi-file-earmark-bar-graph-fill::before {
  content: "\f359";
  font-size: 40px;

  padding: 4px;
}

.bi-plus::before {
  font-size: 40px;
  font-weight: 627 !important;
  padding: 18px;
}

.btn {
  font-weight: 600 !important;
  font-size: 20px;
}

.custom-popover {

  position: absolute;
  background-color: #fff;
  border: 1px solid #ccc;
  padding: 10px;
  z-index: 9999;

}

.popover-header {
  font-weight: bold;
  border-bottom: 1px solid #ccc;
  text-align: center;
}

.popover-body {
  font-size: 13px;
  padding: 2px;

}

</style>