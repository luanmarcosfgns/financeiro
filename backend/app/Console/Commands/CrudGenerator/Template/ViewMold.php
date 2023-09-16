<?php

namespace App\Console\Commands\CrudGenerator\Template;

use App\Console\Commands\CrudGenerator\Util\WriteArchive;
use App\Console\Commands\CrudGenerator\Util\WriteModelText;
use Illuminate\Support\Facades\DB;

class ViewMold
{
    public static function buildView($table)
    {
       $views = self::mold();
       $tableUppercase = self::setTableUppercase($table);
        $columns = self::setColumns($table);
        $tdColumns = self:: buidTdColumns($columns);
        $thColumns = self:: buidThColumns($columns);
      $index = WriteModelText::render($views['index'],
          [':tableUppercase'=>$tableUppercase,
              ':table'=>$table,
              ':tdColumns'=>$tdColumns,
          ':thColumns'=>$thColumns
          ]);

        $inputFom = self::buildInputForm($columns);

      $form = WriteModelText::render($views['form'],
          [':tableUppercase'=>$tableUppercase,
              ':table'=>$table,
              ':inputFom'=>$inputFom
          ]);

        $dataFormSend = self::buildDataForm($columns);
        $dataFormEdit = self::buildEditForm($columns);

      $edit = WriteModelText::render($views['edit'],
          [':tableUppercase'=>$tableUppercase,
              ':table'=>$table,
              ':dataFormEdit'=> $dataFormEdit,
              ':dataFormSend'=>$dataFormSend]);


      $create = WriteModelText::render($views['create'],
          [':tableUppercase'=>$tableUppercase,
              ':table'=>$table,
              ':dataFormSend'=>$dataFormSend]);
      $dir = self::diretorioFrontend();
      $dir = $dir.'/src/views/'.$table.'/';

        WriteArchive::now($index,'Index'.$tableUppercase.'.vue',$dir);
        WriteArchive::now($form,'Form'.$tableUppercase.'.vue',$dir);
        WriteArchive::now($edit,'Edit'.$tableUppercase.'.vue',$dir);
        WriteArchive::now($create,'Create'.$tableUppercase.'.vue',$dir);
     return true;
    }
    public static function mold()
    {
        $quote ="'";
        $data['index'] = '<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5> :tableUppercase</h5>
                    </div>
                    <div class="w-50">
                        <input id="search" class="form-control" @change="list()" placeholder="Digite sua pesquisa"
                               type="text" v-model="search">
                    </div>

                    <div class="float-end">
                        <button-widget cor="azul" href="./create" tamanho="M">
                            Adicionar
                        </button-widget>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    :thColumns
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="row in rows" :key="row.id">
                    <td>{{ row.id }}</td>
                    :tdColumns
                    <td>
                        <div class="btn-group btn-sm" role="group" aria-label="Basic example">
                            <router-link class="btn btn-danger" :to="\'./\'+row.id+\'/edit\'">
                                <i class="bi bi-pencil-square"></i>
                            </router-link>
                            <button class="btn btn-danger" @click="deleteRow(row.id)">
                                <i class="bi bi-trash2-fill"></i>
                            </button>
                        </div>

                    </td>
                </tr>
                 <tr v-if="rows==null">
                    <td colspan="3" class="text-center"> Não há dados</td>
                </tr>
                </tbody>
            </table>

        </div>

    </layout-page>
</template>
<script>
import LayoutPage from "@/components/page/layoutPage.vue";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import RequestHelper from "@/services/RequestHelper";
import Helpers from "@/services/Helpers";
import toastr from "toastr/build/toastr.min";

export default {
    name: "Index:tableUppercase",
    components: {ButtonWidget, LayoutPage},
    data() {
        return {
            rows: null,
            search: null
        }
    },
    methods: {
        async list() {


            let dataRequest = {};
            let requestHelper = new RequestHelper();
            let helpers = new Helpers();

            if (!helpers.empty(this.search)) {
                dataRequest = {
                    search: this.search
                };
            }

            let dataRow = await requestHelper.getAuth(process.env.VUE_APP_API_HOST_NAME + \'/api/:table\', dataRequest);

            if (dataRow.data.data.length > 0) {
                this.rows = dataRow.data.data;

            } else if (!helpers.empty(dataRow.response?.data)) {
                toastr.error(\'Houve um problema\');
            }


        },
        async deleteRow(id){
            let requestHelper = new RequestHelper();
            let dataRow = await requestHelper.deleteAuth(process.env.VUE_APP_API_HOST_NAME + \'/api/:table/\'+id);
           if(dataRow.data.success){
               this.list();
               toastr.success(\'Apagado com sucesso\');
           }else{
               toastr.error(\'Houve um problema ao apagar\');
           }
        }

    },
    created() {
        this.list();

    }
}

</script>

<style scoped>
@import "toastr/build/toastr.css";
@import "bootstrap-icons/font/bootstrap-icons.min.css";
</style>';
        $data['create'] = '<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Adicionar :tableUppercase</h5>
                    </div>
                    <div class="float-end">
                        <button-widget cor="azul" href="./index" tamanho="M">
                            Voltar
                        </button-widget>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <Form:tableUppercase></Form:tableUppercase>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>
</template>
<script>
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import Form:tableUppercase from "@/views/:table/Form:tableUppercase.vue";
import RequestHelper from "@/services/RequestHelper";
import toastr from "toastr/build/toastr.min";

export default {
    name: "Create:tableUppercase",
    components: {Form:tableUppercase, LayoutPage, ButtonWidget},
    methods:{
        async sendForm(){
            let dataForm = {
              :dataFormSend

            }
            if(!dataForm.parent_id){
                delete dataForm.parent_id
            }
            let request =  new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + \'/api/:table\',dataForm);
            if(response.data?.id){
                location.href = \'./\'+response.data.id+\'/edit\';
            }else{
                if (response.response.data?.message){
                    toastr.error(response.response.data?.message);
                }else{
                    toastr.error(\'Houve um problema ao inserir\');
                }

            }
        }
    }
}
</script>
<style scoped>
</style>';


        $data['form'] = '<template>
       :inputFom
</template>

<script>
import InputForm from "@/components/form/inputForm.vue";
import RequestHelper from "@/services/RequestHelper";


export default {
    name: "Form:tableUppercase",
    components: {InputForm},
    data() {
        return {:table: null}
    },
    methods:{
         async get:tableUppercase(){
            let request =  new RequestHelper();
            this.:table = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + \'/api/:table/list\',{});
             this.:table =  await this.:table.data;

        },


    },
    created() {
        this.get:tableUppercase();
    }
}
</script>

<style scoped>
@import "toastr/build/toastr.css";
</style>';
        $data['edit'] = '<template>
    <layout-page>
        <div class="card-header">
            <div class="row">
                <div class="col-12 ps-4 pt-3 ">
                    <div class="float-start">
                        <h5>Editar :tableUppercase</h5>
                    </div>
                    <div class="float-end">
                        <button-widget cor="azul" href="../index" tamanho="M">
                            Voltar
                        </button-widget>
                    </div>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <Form:tableUppercase></Form:tableUppercase>
                <button class="btn btn-primary mt-4" type="button" @click="sendForm">Salvar</button>
            </div>
        </div>
    </layout-page>

</template>

<script>
import Form:tableUppercase from "@/views/:table/Form:tableUppercase.vue";
import RequestHelper from "@/services/RequestHelper";
import ButtonWidget from "@/components/widget/buttonWidget.vue";
import LayoutPage from "@/components/page/layoutPage.vue";
import toastr from "toastr/build/toastr.min";

export default {
    name: "Edit:tableUppercase",
    components: {LayoutPage, ButtonWidget, Form:tableUppercase},
    methods:{
       async edit(id){
            let request = new RequestHelper();
            let response = await request.getAuth(process.env.VUE_APP_API_HOST_NAME + \'/api/:table/\'+id,{});
           :dataFormEdit
        },
        async sendForm(){
            let dataForm = {
                  :dataFormSend
                _method:\'PUT\'

            }
            if(!dataForm.parent_id){
                delete dataForm.parent_id
            }
            let request =  new RequestHelper();
            let response = await request.postAuth(process.env.VUE_APP_API_HOST_NAME + \'/api/:table/\'+this.$route.params.id,dataForm);
            if(response.data?.id){
               toastr.success(\'Salvo com sucesso\')
            }else{
                if (response.response.data?.message){
                    toastr.error(response.response.data?.message);
                }else{
                    toastr.error(\'Houve um problema ao inserir\');
                }

            }
        }
    },
  created() {
    this.edit(this.$route.params.id)
  }
}
</script>

<style scoped>

</style>';
        return $data;
    }


    private static function setColumns($table)
    {
        $database = getenv('DB_DATABASE');

        $sql = "select COLUMN_NAME as name, DATA_TYPE as type, CHARACTER_MAXIMUM_LENGTH as length,IS_NULLABLE as is_nullable,COLUMN_TYPE AS type_column
from information_schema.COLUMNS
where TABLE_NAME = ':table'
    and TABLE_SCHEMA = ':database'
    and COLUMN_NAME not in ('created_at','updated_at','id')
    ";

        $sql = str_replace(':table', $table, $sql);
        $sql = str_replace(':database', $database, $sql);

        $columns = DB::select($sql);
        if(empty($columns)){
            echo 'The table not exists'.PHP_EOL;
            die();
        }
        return $columns;
    }

    private static function buidTdColumns(array $columns) :string
    {
        $html ='';
        foreach ($columns as $i=>$column){
            if($i<8){
                $html .='                    <td>{{row.'.$column->name.'}}</td>'.PHP_EOL;
            }

        }
        return $html;
    }

    private static function buidThColumns(?array $columns):string
    {
        $html ='';
        foreach ($columns as $i=>$column){
            if($i < 8){
                $html .='                    <th>'.ucfirst($column->name).'</th>'.PHP_EOL;
            }

        }
        return $html;
    }

    private static function buildInputForm(array $columns):string
    {
        $html ='';

        foreach ($columns as $column){
            $label = str_replace('_id','',$column->name);
            $label = str_replace('_',' ',$label);
            $label = str_replace('cnpj','CNPJ',$label);
            $label = str_replace('cpf','CPF',$label);
            $label = str_replace('rg','RG',$label);
            $label = str_replace('ie','IE',$label);
            $label = str_replace('endereco','Endereço',$label);
            $label = str_replace('numero','Número',$label);
            $labelArray = explode(' ',$label);
            $label ='';
            foreach ($labelArray as $item) {
               $label .= ucfirst($item).' ';
            }


            if($column->type=='varchar'){
                $html .= '<input-form class-list="col-12"  type="string" label="'.$label.'" value="" name="'.$column->name.'"/>'.PHP_EOL;
            }elseif ($column->type=='longtext'){
                $html .= '<input-form class-list="col-12"  type="text" label="'.$label.'" value="" name="'.$column->name.'"/>'.PHP_EOL;
            }elseif (strpos($column->name,'_id')){
                $table = str_replace('_id','',$column->name);
                $html .='  <input-form placeholder="Selecione ' .$label.'" class-list="col-12" type="select" :items="' .$table.'" label="' .$label.'" value="" name="'.$column->name.'"/>'.PHP_EOL;
            }elseif ($column->type=='enum'){
                $enum =  str_replace('enum(','',$column->type_column);
                $enum =  str_replace(')','',$enum);

                $columnTypes = explode(',',$enum);

                $data = '[';
                foreach ($columnTypes as $columnType) {

                    $data .= "{id:".$columnType.',message:'.$columnType.",},";
                }
                $data .= ']';

                $html .='  <input-form placeholder="Selecione '.$label.'" class-list="col-12" type="select" :items="' .$data.'" label="' .$label.'" value="" name="'.$column->name.'"/>'.PHP_EOL;
            }else{
                $html .= '<input-form class-list="col-12"  type="'.$column->type.'" label="'.$label.'" value="" name="'.$column->name.'"/>'.PHP_EOL;
            }

        }
        return $html;
    }

    private static function buildDataForm(?array $columns):string
    {
        $script ='';
        foreach ($columns as $column){
            $script .=  $column->name.": document.getElementById('".$column->name."').value,".PHP_EOL;
        }
        return $script;
    }

    private static function buildEditForm(?array $columns):string
    {
        $script ='';
        foreach ($columns as $column){
            $script .="document.getElementById('".$column->name."').value = response.data.".$column->name.';'.PHP_EOL;
        }
        return $script;
    }

    private static function diretorioFrontend():string
    {
        $dirArray = explode('/',base_path());
        $numberArray = count($dirArray);
        $dirArray[($numberArray-1)]= 'frontend';
        return implode('/',$dirArray);
    }

    private static function setTableUppercase($table):string
    {
        $listModelName = explode('_',$table);
        $numberListName = count($listModelName);
        $modelName = "";
        foreach ($listModelName as $i => $word) {
            $modelName .= ucfirst($word);

        }
        return $modelName;

    }
}
