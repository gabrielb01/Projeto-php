<div class="container-fluid">
    <div class="center">
        <div class="col-sm-3 col-xs-3">
            <form class="form-autenticao" method="post" action="http://<?= PATH ?>/accounts/validarLogin">
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