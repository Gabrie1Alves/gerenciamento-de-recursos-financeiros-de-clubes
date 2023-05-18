
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