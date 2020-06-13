<div class="flex-container" style="height:100%">
    <div class="bg-white">
        <form action="<?=PROTOCOLO?>://<?=PATH?>/accounts/editarsenha/<?=$this->token?>" method="post">
            <div class="form-group">
                <h3>Nova senha</h3>
                <input type="password" class="form-control" id="pass1" name="pass1" placeholder="Senha" autocomplete="off" minlength="8" required>
            </div>
            <div class="form-group">
                <h3>Diginte novamente a senha</h3>
                <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Senha" autocomplete="off" minlength="8" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Salvar senha" id="btn-new-password" class="btn btn-success" disabled="disabled">
            </div>
        </form>
    </div>
</div>