<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerencimento de clubes</title>
    <!-- <link rel="sortcut icon" href="" type="image/x-icon"> -->
    <link rel="stylesheet" href="./Css/geral.css?v1<?=rand(1,9999)?>">
    <script type="text/javascript" src="./JavaScript/consumoAPI.js?v1<?=rand(1,9999)?>"></script>
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
</head>
<body>
    <?php
    // busca todos os registros de clubes do banco
        $clubes = file_get_contents('http://localhost/gerenciamento-de-recursos-financeiros-de-clubes/APIPHP/public_html/api/user/clube');
        $clubes = json_decode($clubes); 

        $recursos = file_get_contents('http://localhost/gerenciamento-de-recursos-financeiros-de-clubes/APIPHP/public_html/api/user/recurso');
        $recursos = json_decode($recursos); 
    ?>
    <div class="top">
        <span class="title">Gerenciamento de recursos de clubes</span>
    </div>

    <div class="actions">
        <button class="btn" onclick="cadastroModal()">Cadastrar Clube</button>
        <button class="btn" onclick="consumoModal()">Consumir recurso</button>
    </div>
        
    <div class="club_list">
        <h1 class="title">Lista de clubes</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Clube</th>
                <th>Saldo</th>
            </tr>
            <?php foreach($clubes->data as $clube):?>
                <tr>
                    <td><?=$clube->id?></td>
                    <td><?=$clube->clube?></td>
                    <td>R$ <?=number_format($clube->saldo_disponivel, 2, ',', '.')?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
    <div class="low">
        © Gerenciamento de recursos de clubes - 2023
    </div>

    <!-- Modais -->
    <div class="modal-background d-none">

        <div class="modal modal_cadastrar d-none">
            <h2 class="title">Cadastrar novo clube</h2>
            <label for="nome">Nome do clube</label> <br>
            <input type="text" name="nome" id="nome"> <br>

            <label for="saldo">Saldo</label> <br>
            <input type="text" name="nome" id="saldo"> <br>

            <div class="campos_invalid">

            </div>

            <button class="btn" onclick="cadastrarClube()">Cadastrar</button>
            <button class="btn btn-cancelar" onclick="cancelarAction('.modal_cadastrar')">Cancelar</button>
        </div>

        <div class="modal modal_consumir d-none">
            <h2 class="title">Consumir recurso de clube</h2>

            <label for="nome">Nome do clube</label> <br>
            <select name="nome" id="nome">
                <?php foreach($clubes->data as $clube):?>
                    <option value="<?=$clube->id?>"><?=$clube->clube?></option>
                <?php endforeach;?>
            </select> <br>

            <label for="recurso">Recurso do clube</label> <br>
            <select name="recurso" id="recurso">
                <?php foreach($recursos->data as $recurso):?>
                    <option value="<?=$recurso->id?>"><?=$recurso->recurso?></option>
                <?php endforeach;?>
            </select> <br>

            <label for="nome">Saldo</label> <br>
            <input type="text" name="nome" id="saldo"> <br>
            <div class="campos_invalid_consumo">
                
            </div>
            <button class="btn" onclick="realizarConsumo()">Consumir recurso</button>
            <button class="btn" onclick="cancelarAction('.modal_consumir')">Cancelar</button>
        </div>

        <div class="modal modal_sucesso d-none">
            <h2 class="title">Sucesso!</h2>
            <button class="btn" onclick="refresh()">Fechar</button>
        </div>

        <div class="modal modal_falha d-none">
            <h2 class="title">Algo deu errado! Tente novamente.</h2>
            <button class="btn" onclick="refresh()">Fechar</button>
        </div>

    </div>

    <script>
        var recursos = <?=json_encode($recursos)?>;
        var clubes = <?=json_encode($clubes)?>;
    </script>
</body>
</html>