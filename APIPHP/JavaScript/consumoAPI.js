/**
 * Abre modal de cadastro de um novo clube ou realizar algum consumo
 */
function cadastroModal(){
    $('.modal_cadastrar, .modal-background').removeClass('d-none');

}

function consumoModal() {
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
        console.log(infos);
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

    }
}