<div class="container-flex">
    <div class="container-flex-left">
        <div class="container-nav">
            <div class="list-group">
                <a href="<?= PROTOCOLO ?>://<?= PATH ?>/u/edit/editar-perfil" class="list-group-item list-group-item-action <?= $acao == "editar-perfil" ? "active" : "" ?>">Editar Perfil</a>
                <a class="list-group-item list-group-item-action <?= $this->acao == "editar-usuario" ? "active" : "" ?>" href="<?= PROTOCOLO ?>://<?= PATH ?>/u/edit/editar-usuario">Editar Usuario</a>
                <a class="list-group-item list-group-item-action <?= $this->acao == "editar-email" ? "active" : "" ?>" href="<?= PROTOCOLO ?>://<?= PATH ?>/u/edit/editar-email">Editar Email</a>
                <a class="list-group-item list-group-item-action <?= $this->acao == "editar-senha" ? "active" : "" ?>" href="<?= PROTOCOLO ?>://<?= PATH ?>/u/edit/editar-senha">Editar Senha</a>
                <a class="list-group-item list-group-item-action <?= $this->acao == "excluir-conta" ? "active" : "" ?>" href="<?= PROTOCOLO ?>://<?= PATH ?>/u/edit/excluir-conta">Excluir Conta</a>

            </div>
        </div>
    </div>
    <div class="container-flex-right">
        <div class="container-main">
            <?php if ($this->acao == "editar-perfil") : ?>
                <form class="form-edit-profile" action="<?= PROTOCOLO ?>://<?= PATH ?>/u/editarDadosUsuario" method="post">
                    <div class="form-group">
                        <h2>Nome</h2>
                        <input type="text" name="nome" class="form-control" value="<?= $this->dados[0]['nome'] ?>" required>
                    </div>
                    <div class="form-group">
                        <h2>Sobrenome</h2>
                        <input type="text" name="sobrenome" class="form-control" value="<?= $this->dados[0]['sobrenome'] ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="form" value="formFullName">
                        <button class="btn btn-primary btn-lg">Salvar</button>
                    </div>
                    <?php alert(); ?>
                </form>
            <?php endif; ?>
            <?php if ($this->acao == "editar-usuario") : ?>
                <form action="<?= PROTOCOLO ?>://<?= PATH ?>/u/editarDadosUsuario" method="post" class="form-edit-profile">
                    <div class="form-group">
                        <h2>Usuario</h2>
                        <input type="text" name="usuario" class="form-control" value="<?= $this->dados[0]['usuario'] ?>" required>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="form" value="usuario_c">
                        <button class="btn btn-primary btn-lg">Salvar</button>
                    </div>
                </form>
                <?php alert(); ?>

            <?php endif; ?>
            <?php if ($this->acao == "editar-email") : ?>
                <form action="<?= PROTOCOLO ?>://<?= PATH ?>/u/editarDadosUsuario" class="form-edit-profile" method="post">
                    <div class="form-group">
                        <h2>Email</h2>
                        <input type="text" name="email" class="form-control" value="<?= $this->dados[0]['email'] ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="form" value="email_c">
                        <button class="btn btn-primary btn-lg">Salvar</button>
                    </div>
                </form>
            <?php endif; ?>

            <?php alert(); ?>


            <?php if ($this->acao == "editar-senha") : ?>
                <form action="<?= PROTOCOLO ?>://<?= PATH ?>/u/editarDadosUsuario" class="form-edit-profile" method="post">
                    <div class="form-group">
                        <h2>Sua Senha</h2>
                        <input type="password" name="senha_original" class="form-control"required>
                    </div>
                    <div class="form-group">
                        <h2>Nova Senha</h2>
                        <input type="password" name="senha" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <h2>Digite a senha novamente</h2>
                        <input type="password" name="senha2" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="form" value="senha_c">
                        <button class="btn btn-primary btn-lg">Salvar</button>
                    </div>
                </form>


            <?php endif; ?>

            <?php alert(); ?>


            <?php if ($this->acao == "excluir-conta") : ?>
                <form action="<?= PROTOCOLO ?>://<?= PATH ?>/usuario/editarDadosUsuario" class="form-edit-profile" method="post">
                    <h2>Você quer excluir Sua Conta?</h2> <br>
                    <input type="hidden" name="form" value="excluir">
                    <button class="btn btn-success btn-lg">Sim</button>
                    <a class="btn btn-primary btn-lg" href="<?= PROTOCOLO ?>://<?= PATH ?>/usuario/profile/<?= $_SESSION['usuario'] ?>">Não</a>
                </form>
            <?php endif; ?>

        </div>
    </div>
</div>