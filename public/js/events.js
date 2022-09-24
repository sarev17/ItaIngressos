$('.load').attr("disabled", true);
/**
 * checando de todos os inputs estão preenchidos
 */
 function checkInputs(inputs,selects) {
    var filled = true;
    // console.log('teste');
    inputs.forEach(function(input) {
      if(input.required){
        if(input.value === "") {
            filled = false;
            console.log(input);
        }
      }
    });
    selects.forEach(function(select) {
      if(select.required){
        if(select.value === "") {
            filled = false;
            console.log(select);
        }
      }
    });

    return filled;
  }


$(document).ready(function() {

    //desabilita o botão de classe load se houver inputs vazios
    var inputs = document.querySelectorAll("input");
    var selects = document.querySelectorAll("select");
    $(':input').change(function(event){
        event.preventDefault();
        if(checkInputs(inputs,selects)) {
            $('.load').attr("disabled", false);
        }else{
            $('.load').attr("disabled", true);
        }
    })

    //carrega mensagem de load
    $('.load').click(function(event) {
        event.preventDefault();
        $(this).text('');
        $(this).append('AGUARDE <i class="fa-spin fa-solid fa-spinner"></i>');
        $('.load').attr("disabled", true);
        $('.formSub').submit();
    });
});
