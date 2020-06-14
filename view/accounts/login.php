<?php

    if (!defined('INDEX')) {
      die("Erro no sistema!");
    }
?>
<div class="container-fluid">
    <div class="center">
        <div class="col-sm-3 col-xs-3">
            <form class="form-autenticao form" method="post" id="formLogin" action="http://<?= PATH ?>/accounts/validarLogin">
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
                    <input type="submit" class="btn btn-primary btn-lg btn-submit" value="Entrar" />
                </div>
                <a href="<?=PROTOCOLO?>://<?=PATH?>/accounts/cadastro">Cadastrar Grátis</a> <br>
                <a href="<?=PROTOCOLO?>://<?=PATH?>/accounts/forgot">Esqueceu a senha?</a>
            </form>
        </div>
    </div>
</div>