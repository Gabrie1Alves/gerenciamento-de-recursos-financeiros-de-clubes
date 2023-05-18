<?php
    header('Content-Type: application/json');
    //com o require do composer, não preciso colocar vários require
    require_once '../vendor/autoload.php';

    if ($_GET['url']) {
        //cria um array com o link
        $url = explode('/', $_GET['url']);

        //verifica se está tentando acessar a API
        if ($url[0] === 'api') {
            //elimina a posição Zero do array
            array_shift($url);
            //como na função 'call_user_func_array' é preciso informar o namespace
            //eu já concateno tudo aqui pra ficar pronto
            $service = 'App\Services\\'.ucfirst($url[0]).'Service';
            array_shift($url);
            
            //pega o método solicitado e passa o mesmo para minúsculo
            $method = strtolower($_SERVER['REQUEST_METHOD']);

            try {
                //se der algum erro dentro do try
                //ele vai para o catch para informar o erro
                //passo o serviço, método e a informação solicitada se houver
                $response = call_user_func_array(array(new $service, $method), $url);

                http_response_code(200);
                echo json_encode(array('status' => 'sucess', 'data' => $response));
                exit;
            } catch (\Exception $e) {
                http_response_code(404);
                // 'JSON_UNESCAPED_UNICODE' utilizado para nao bugar acentuação etc
                echo json_encode(array('status' => 'error', 'data' => $e->getMessage()), JSON_UNESCAPED_UNICODE);
                exit;
            }
        }
    }
?>
    