<?php if(isset($_SESSION["CADASTRO_SUCESSO"])): ?>
    <div class="alert alert-dark" role="alert">
     <?php echo $_SESSION["CADASTRO_SUCESSO"]; ?>
</div>


<?php 

unset($_SESSION["CADASTRO_SUCESSO"]);

endif;?>


<?php if(isset($_SESSION["ERROR_DATA_OUT"])): ?>

<div class="alert alert-dark" role="alert">
 <?php echo $_SESSION["ERROR_DATA_OUT"]; ?>
 
</div>

<?php 

unset($_SESSION["ERROR_DATA_OUT"]);

endif;?>

<?php if(isset($_SESSION["ERROR_DATA_LOGIN"])): ?>

<div class="alert alert-dark" role="alert">
 <?php echo $_SESSION["ERROR_DATA_LOGIN"]; ?>
 
</div>

<?php 

unset($_SESSION["ERROR_DATA_LOGIN"]);

endif;?>
<div class="container-fluid">
    <div class="center">
        <div class="col-sm-3 col-xs-3">
            <form class="form-autenticao" method="post" action="http://<?=PATH?>/autenticacao/validarLogin">
                <div class="form-group">
                    <h2>Login</h2>
                </div>
                <div class="form-group">
                    <h3>Email</h3>
                    <input type="text" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <h3>Senha</h3>
                    <input type="password" class="form-control" name="senha">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg">Entrar</button>
                </div>
                <a href="cadastro">Cadastrar Grátis</a>
                
            </form>
        </div>
    </div>
</div>