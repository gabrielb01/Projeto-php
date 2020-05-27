
$(document).ready(function() {
    const PROTOCOLO = "http";
    const PATH = window.location.hostname;
    
    
    $('#usuario').blur(function() {
       if ($('#usuario').val() !="") {
           let url = `${PROTOCOLO}://${PATH}/api/verificarusuario.php`;
           let data = { data: $('#usuario').val(), tipo: "usuario" };
           ajax(data,"Este usuário está disponível","Este usuário não está disponível", url, "msg-usuario" );
       }
    });




    $('#email').blur(function() {
        let url = `${PROTOCOLO}://${PATH}/api/verificarusuario.php`;
        let data = { data: $('#email').val(), tipo: "email" };
        ajax(data,"","Este email está sendo usando por outro usuário", url, "msg-email" );
    });
});





function ajax(data,msg_success,msg_fail, url, obj) 
{
    $.ajax({
        url: url,
        type: "post",
        data:data,
        success: function(res) {
            if(res=="0") {
                $("#"+obj).html(msg_success);
            } else {
                $("#"+obj).html(msg_fail);
            }
        }
    });
}