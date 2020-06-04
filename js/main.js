
$(document).ready(function() {
    const PROTOCOLO = "http";
    const PATH = window.location.hostname +"/vegan";
    let show = false;



    
    
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



    

    $("#trash").click(function() {
        if (confirm("Tem certeza que você quer EXCLUIR essa categoria")) {
            location.href = PROTOCOLO +"://" + PATH + "/categoria/excluir/"+ $("#trash").attr("name");
        }
    });

    $("#trash-Receita").click(function() {
        if (confirm("Tem certeza que você quer EXCLUIR essa receita")) {
            location.href = PROTOCOLO +"://" + PATH + "/receita/excluir/"+ $("#trash-Receita").attr("name");
        }
    });

    $("#formNewReceita").submit(function() {
        lines();
    });

    $("#fotoReceita").change(function(event) {

        let fileReader = new FileReader();
        fileReader.onload = function(e) {
            $("#imagemReceita").attr("src",e.target.result);
        }
        fileReader.readAsDataURL(event.target.files[0]);

        
    });

    $(".single-receita i").click(function() {
        if (!show) {
            $("#singleOption")[0].style.display = "block";
            show =true;
        } else {
            $("#singleOption")[0].style.display = "none";
            show = false;
        }
    });


});

function lines() {
    let lines = $('#text-ingredientes').val().split(/\n/);
    let contentLines = [];
    for (let i=0; i < lines.length; i++) {
        if (/\S/.test(lines[i])) {
            contentLines.push($.trim(lines[i]));
        }
    }

    $("#listasFull").val(contentLines);
}







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



