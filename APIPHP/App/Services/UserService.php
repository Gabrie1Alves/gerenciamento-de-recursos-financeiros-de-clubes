<?php
    namespace App\Services;
    use App\Models\Clube;
    use App\Models\Recurso;

    class UserService
    {

      /**
         * Função get realiza select no banco
         */
        
         public function get($action) 
         {
            if($action == 'clube'){
               return Clube::selectAllClubes();
            }else{
               return Recurso::selectAllRecursos();
            }
            
         }
        /**
         * Função post realiza alterações no banco
         */
        public function post($data) 
        {
         
            $data = explode("--", $data);

            $erro = "";
            if($data[0] == "insert"){
               array_shift($data);

               if(strlen($data[0]) < 3){
                  $erro += "O nome do clube deve conter ao menos 3 caracteres!! <br>";
               }

               if(!preg_match('/^[0-9]+(\.[0-9]+)?$/', $data[1])){
                  $erro += "O saldo do clube deve conter somente números e no máximo 1 caracter '.' ou ','!! <br>";
               }

               if($data[1] < 0){
                  $erro += "Não é possível cadastrar um clube com saldo negativo!! <br>";
               }

               $clubes = Clube::selectAllClubes();
               foreach($clubes as $clube){
                  if($clube['clube'] == $data[0]){
                     $erro += "Já existe um clube cadastrado com este nome!! <br>";
                  }
               }
               
               if($erro == ""){
                  return Clube::insertClube($data);
               }else{
                  return $erro;
               }

            }else if($data[0] == "update"){
               array_shift($data);

               

               if(strlen($data[2]) < 0){
                  $erro += "O saldo deve ser positivo!! <br>";
               }

               if(!preg_match('/^[0-9]+(\.[0-9]+)?$/', $data[1])){
                  $erro += "O saldo do clube deve conter somente números e no máximo 1 caracter '.' ou ','!! <br>";
               }

               $clubes = Clube::selectAllClubes();
               $recursos = Recurso::selectAllRecursos();

               foreach($clubes as $clube){
                  if($clube['id'] == $data[0]){
                     if($clube['saldo_disponivel'] - $data[2] < 0){
                        $erro += "Saldo do clube não é suficiente!! <br>";
                     }else{
                        $saldoClube = $clube['saldo_disponivel'] - $data[2];
                     }
                  }
               }

               foreach($recursos as $recurso){
                  if($recurso['id'] == $data[0]){
                     if($recurso['saldo_disponivel'] - $data[2] < 0){
                        $erro += "Saldo dos recursos não é suficiente!! <br>";
                     }else{
                        $saldoRecurso = $recurso['saldo_disponivel'] - $data[2];
                     }
                  }
               }


               if($erro == ""){
                  $returnClube = Clube::update($data[0], $saldoClube);

                  $returnRecurso = Recurso::updateRecurso($data[1], $saldoRecurso);
                  if($returnClube == 1 && $returnRecurso == 1){
                     return "Atualização de valores feita!!";
                  }else{
                     throw new \Exception("Falha ao atualizar recursos!");
                  }
               }else{
                  return $erro;
               }
               return Clube::update($data);
            }
            return $data;

        }

    }