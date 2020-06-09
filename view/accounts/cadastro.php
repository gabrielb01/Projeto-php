<div class="container-fluid">
    <div class="center">
        <div class="col-sm-3 col-xs-3">
            <form class="form-autenticao " method="post" action="<?= PROTOCOLO ?>://<?= PATH ?>/accounts/validarCadastro">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <h2>Cadastro</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Email</h3>
                            <input type="text" name="email" id="email" class="form-control" autocomplete="off" required>
                            <p id="msg-email"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Usuário</h3>
                            <input type="text" name="usuario" id="usuario" class="form-control" autocomplete="off" required>
                            <p id="msg-usuario"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Nome</h3>
                            <input type="text" name="nome" class="form-control" autocomplete="off" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Sobrenome</h3>
                            <input type="text" name="sobrenome" class="form-control" autocomplete="off" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <h3>Senha</h3>
                            <input type="password" name="senha" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="container">
                            <div class="form-group">
                                <h3>Sexo</h3>
                                <input type="radio" id="masculino" name="radio" value="M" checked>
                                <label for="masculino">Masculino</label><br>
                                <input type="radio" id="ferminino" name="radio" value="F">
                                <label for="ferminino">Ferminino</label><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-lg" id=cadastrar">Cadastrar</button>
                </div>
                <a href="<?= PROTOCOLO ?>://<?= PATH ?>/accounts/login">Login</a>

            </form>
        </div>
    </div>
</div>