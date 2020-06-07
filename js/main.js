
$(document).ready(function() {
    const PROTOCOLO = "http";
    const PATH = window.location.hostname +"/vegan";
    let show = false;



    
    
    $('#usuario').blur(function() {
       if ($('#usuario').val() !="") {
           let url = `${PROTOCOLO}://${PATH}/api/verificarusuario.php`;
           let data = { data: $('#usuario').val(), tipo: "usuario" };
           ajax(data, url, "msg-usuario" );
       }
    });




    $('#email').blur(function() {
        let url = `${PROTOCOLO}://${PATH}/api/verificarusuario.php`;
        let data = { data: $('#email').val(), tipo: "email" };
        ajax(data, url, "msg-email" );
    });


    $("#salvarReceita").click(function() {
        let url = `${PROTOCOLO}://${PATH}/api/listareceita.php`;
        let data = { identificacao:$(this).attr("identificacao"), type: $(this).attr("type"),user: $(this).attr("user") };
        ajax(data, url, "msg-receita" );
        setTimeout(function() {
            location.reload();
        },2000);
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


    $("#fotoPerfil").change(function(event) {

        let fileReader = new FileReader();
        fileReader.onload = function(e) {
            $("#imagemPerfil").attr("src",e.target.result);
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


    $(".profile-img").click(function() {
        $(".div-popup").css("top","25%");
        $(".div-popup").css("opacity","1");
        $("body").css("overflow-y","hidden");
    });

    $(".close").click(function() {
        $(".div-popup").css("top","-60%");
        $(".div-popup").css("opacity","0");
        $("body").css("overflow-y","scroll");
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







function ajax(data, url, obj) 
{
    $.ajax({
        url: url,
        type: "post",
        data:data,
        success: function(res) {
            $("#"+obj).html(res);
        }
    });
}



