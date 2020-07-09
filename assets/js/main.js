
$(document).ready(function() {
    const PROTOCOLO = "http";
    const PATH = window.location.hostname +"/vegan";
    let show = false;
    let email = false;
    let usuario = false;





    $("#salvarReceita").click(function() {
        let url = `${PROTOCOLO}://${PATH}/api/listareceita.php`;
        let data = { identificacao:$(this).attr("identificacao"), type: $(this).attr("type"),user: $(this).attr("user") };

        ajax(data, url, "msg-receita" );
        $("#msg-receita").css({display: "block"});
        setTimeout(function() {
            location.reload();
        },2000);
    });

    $("#email-forgot").keyup(function() {
        if ($(this).val()!="") {
            let exp_email = /^[a-zA-Z0-9][a-zA-Z0-9\._-]+@([a-zA-Z0-9\._-]+\.)[a-zA-Z-0-9]{2,3}/;
            if (exp_email.test($(this).val())) {
                $("#btn-forgot").removeAttr('disabled');
            } else {
                $("#btn-forgot").attr('disabled','disabled');
            }
        } else {
            $("#btn-forgot").attr('disabled','disabled');
        }
    }); 

    $(".form").submit(function() {
        $(".btn-submit").attr('disabled','disabled');
    });

    $("#pass1").keyup(function() {
        validarCampo();
    });
    $("#pass2").keyup(function() {
        validarCampo();
    });
    

    function validarCampo() {
        if($("#pass1").val().length >=8 && $("#pass2").val().length >= 8) {
            if($("#pass1").val() == $("#pass2").val()) {
                $("#btn-new-password").removeAttr('disabled');
            } else {
                $("#btn-new-password").attr('disabled','disabled');
            }
        } else {
            $("#btn-new-password").attr('disabled','disabled');
        }

    }

    

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
            if (res=="false") {
                return false;
            } else {
                $("#"+obj).html(res);
            }
        }
    });
}



