/**
 * Abre modal de cadastro de um novo clube ou realizar algum consumo
 */
function cadastroModal(){

    $('.modal_cadastrar #nome').val('');
    $('.modal_cadastrar #saldo').val('');

    $('.modal_cadastrar, .modal-background').removeClass('d-none');

}

function consumoModal() {

    $('.modal_consumir #nome').val('');
    $('.modal_consumir #recurso').val('');
    $('.modal_consumir #saldo').val('');

    $('.modal_consumir, .modal-background').removeClass('d-none');

}

/**
 * Fecha o modal passado na parâmetro
 * @param {string} action 
 */
function cancelarAction(action){
    $(action +', .modal-background').addClass('d-none');
}

/**
 * Recarrega página após alguma alteração
 */
function refresh() {
    $('.modal-background').addClass('d-none');
    location.reload();
}

/**
 * Função para cadastrar um novo clube
 */
function cadastrarClube() {

    let nome = $('.modal_cadastrar #nome').val();
    let saldo = $('.modal_cadastrar #saldo').val().replace(',', '.');;
    let data = [nome, saldo];

    
    const verifica = verify('insert', data);

    //entradas válidas
    if(verifica == ''){
        const infos = `insert--${nome}--${saldo}`;

        fetch("http://localhost/gerenciamento-de-recursos-financeiros-de-clubes/APIPHP/public_html/api/user/"+infos, {
        method: "POST",
        headers: {'Content-Type': 'application/json'}
        }).then(response => response.json())
        .then(data => {
            if(data['status'] == 'sucess'){
                $('.modal_sucesso').removeClass('d-none');
                $('.modal_cadastrar').addClass('d-none');
            }else{
                $('.modal_falha').removeClass('d-none');
                $('.modal_cadastrar').addClass('d-none');
            }
        });
    }else{
        $('.campos_invalid').html(verifica);
    }
}


/**
 * Função para realizar alterações de saldo
 */
function realizarConsumo() {
    let nome_id = $('.modal_consumir #nome').val();
    let recurso_id = $('.modal_consumir #recurso').val();
    let saldo = $('.modal_consumir #saldo').val().replace(',', '.');
    let data = [nome_id, recurso_id, saldo];

    const verifica = verify('update', data);
    console.log(saldo);
    if(verifica == ''){
        const infos = `update--${nome_id}--${recurso_id}--${saldo}`;

        fetch("http://localhost/gerenciamento-de-recursos-financeiros-de-clubes/APIPHP/public_html/api/user/"+infos, {
        method: "POST",
        headers: {'Content-Type': 'application/json'}
        }).then(response => response.json())
        .then(data => {
            if(data['status'] == 'sucess'){
                $('.modal_sucesso').removeClass('d-none');
                $('.modal_consumir').addClass('d-none');
            }else{
                $('.modal_falha').removeClass('d-none');
                $('.modal_consumir').addClass('d-none');
            }
        });
    }else{
        $('.campos_invalid_consumo').html(verifica);
    }
}

/**
 * Função que verifica o formulário
 * @param {string} action 
 */
function verify(action, data){
    let erro = '';
    const regex = /^[0-9.]+$/;
    if(action == 'insert'){
        if(data[0].length < 3){
            erro += 'O nome do clube deve conter ao menos 3 caracteres!! <br>';
        }
        if(!regex.test(data[1])){
            erro += 'O saldo do clube deve conter somente números e no máximo 1 caracter "." ou ","!! <br>';
        }
        if(data[1] < 0){
            erro += 'Não é possível cadastrar um clube com saldo negativo!! <br>';
        }

        clubes.data.forEach(clube => {
            if(clube['clube'] == data[0]){
                erro += 'Já existe um clube cadastrado com este nome!! <br>';
                return erro;
            }
        });

        return erro;
    }else{
        if(!regex.test(data[2])){
            erro += 'O saldo que será utilizado do clube deve conter somente números e no máximo 1 caracter "." ou ","!! <br>';
        }

        if(data[2] < 0){
            erro += 'O saldo que será utilizado do clube não pode ser negativo!! <br>';
        }

        clubes.data.forEach(clube => {
            if(clube['id'] == data[0]){
                if(parseFloat(clube.saldo_disponivel) - parseFloat(data[2]) < 0){
                    erro += `O clube ${clube.clube} tem R$ ${clube.saldo_disponivel}, não é possível utilizar R$ ${data[2]}!! <br>`;
                }
            }
        });
        recursos.data.forEach(recurso => {
            if(recurso['id'] == data[1]){
                if(parseFloat(recurso.saldo_disponivel) - parseFloat(data[2]) < 0){
                    erro += `Existe apenas R$ ${recurso.saldo_disponivel} em recursos disponíveis, não é possível utilizar R$ ${data[2]}!! <br>`;
                }
            }
        });

        return erro;
    }
}