<?php if(isset($_SESSION["ERROR_DATA_PASSWORD"])): ?>
<div class="alert alert-dark" role="alert">
 <?php echo $_SESSION["ERROR_DATA_PASSWORD"]; ?>
</div>

<?php 

unset($_SESSION["ERROR_DATA_PASSWORD"]);

endif;?>

<?php if(isset($_SESSION["ERROR_DATA_OUT"])): ?>

<div class="alert alert-dark" role="alert">
 <?php echo $_SESSION["ERROR_DATA_OUT"]; ?>
 
</div>

<?php 

unset($_SESSION["ERROR_DATA_OUT"]);

endif;?>


<div class="container-fluid">
    <div class="center">
        <div class="col-sm-3 col-xs-3">
            <form class="form-autenticao " method="post" action="<?=PROTOCOLO?>://<?=PATH?>/autenticacao/validarCadastro">
                <div class="form-group">
                    <h2>Cadastro</h2>
                </div>
                <div class="form-group">
                    <h3>Email</h3>
                    <input type="text"name="email" id="email" class="form-control">
                    <p id="msg-email"></p>
                </div>
              
                <div class="form-group">
                    <h3>Nome</h3>
                    <input type="text" name="nome" class="form-control">
                </div>
                <div class="form-group">
                    <h3>Sobrenome</h3>
                    <input type="text" name="sobrenome" class="form-control">
                </div>
                <div class="form-group">
                    <h3>Usuário</h3>
                    <input type="text" name="usuario" id="usuario" class="form-control">
                    <p id="msg-usuario"></p>
                </div>
                <div class="form-group">
                    <h3>Senha</h3>
                    <input type="password" name="senha" class="form-control ">
                </div>
                <div class="container">
                    <div class="form-group">
                        <h3>Sexo</h3>
                        <input type="radio" id="masculino" name="radio" value="m" >
                        <label for="masculino" >Masculino</label><br>
                        <input type="radio" id="ferminino"  name="radio" value="f">
                        <label for="ferminino">Ferminino</label><br>
                  </div>    
              </div>       
                <div class="form-group">
                    <button class="btn btn-primary btn-lg" id=cadastrar">Cadastrar</button>
                </div>
                <a href="#">Login</a>
                
            </form>
        </div>
    </div>
</div>