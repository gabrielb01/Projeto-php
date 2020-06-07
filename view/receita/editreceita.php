<?php

$database = ReceitaController::getConnect();

$receita = $database->query("SELECT * FROM RECEITA WHERE id_receita=:id", [":id" => $id]);
$ingredientes = explode(',', $receita[0]['ingredientes']);



?>
<?php if (isset($_SESSION["ERROR_DATA_OUT"])) : ?>

    <div class="alert alert-dark" role="alert">
        <?php echo $_SESSION["ERROR_DATA_OUT"]; ?>

    </div>

<?php

    unset($_SESSION["ERROR_DATA_OUT"]);
endif;

?>


<br><br>
<div class="container">
    <div class="col-md-8 offset-md-2 col-sm-12 col-12">
        <div class="receita-content">
            <form action="<?= PROTOCOLO ?>://<?= PATH ?>/receita/validareditreceita/<?=$receita[0]['id_receita']?>" method="post" id="formNewReceita" enctype="multipart/form-data" class="form-add-categoria">
                <div class="form-group">
                    <h3>Nome da Receita</h3>
                    <input type="text" class="form-control" name="nomeReceita" autocomplete="off" required placeholder="Nome da Receita" value="<?= $receita[0]['titulo'] ?>">
                </div>
                <div class="form-group">
                    <h3>Ingredientes</h3>
                    <textarea class="form-control" id="text-ingredientes" rows="5" placeholder="Um ingrediente por linha" required><?php foreach ($ingredientes as $i) : ?><?= $i . "\n" ?><?php endforeach; ?>
                </textarea>
                    <input type="hidden" name="ingredientes" id="listasFull">
                </div>
                <br><br>
                <div class="form-group">
                    <h3>Modo de Fazer</h3>
                    <textarea class="form-control" name="descricao" rows="5" required placeholder="Modo de Fazer"><?= $receita[0]['mododefazer'] ?></textarea>
                </div>
                <div class="form-group">
                    <h3>Categoria</h3>
                    <select name="categoria" class="form-control">
                        <?php
                        $database = ReceitaController::getConnect();
                        $categorias = $database->query("SELECT * FROM CATEGORIA");
                        foreach ($categorias as $categoria => $value) :
                        ?>
                            <option value="<?= $value['nome_categoria'] ?>"><?= $value['nome_categoria'] ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <h3>Imagem</h3>
                    <img id="imagemReceita" width="200px" height="200px" src="<?= PROTOCOLO . "://" . PATH . "/" . $receita[0]['foto_receita'] ?>" />
                    <input type="file" name="fotoReceita" accept="image/*" id="fotoReceita"/>
                </div>

                <div class="form-group">
                    <input type="submit" value="Salvar" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
</div>