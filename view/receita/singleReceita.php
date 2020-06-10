<?php

    if (!defined('INDEX')) {
      die("Erro no sistema!");
    }
?>
<br><br>

<div class="container">
    <div class="single-receita">
        <div class="row">
            <div class="col-md-7 col-12">
                <div class="single-receita-content">
                    <img src="<?= PROTOCOLO . "://" . PATH . "/" . $this->receita[0]['foto_receita'] ?>" width="100%" height="300px">
                    <div class="border p-3">
                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        <div id="singleOption">
                            <div class="col-md-2 p-0 col-3">
                                <ul class="list-group">
                                    <?php if ($_SESSION['user'] == $this->receita[0]['id_usuario']) : ?>
                                        <a href="<?= PROTOCOLO ?>://<?= PATH ?>/receita/edit/<?= $this->receita[0]['id_receita'] ?>">
                                            <li class="list-group-item">Editar</li>
                                        </a>

                                        <a id="trash-Receita" href="#" name="<?= $this->receita[0]['id_receita'] ?>">
                                            <li class="list-group-item">Excluir</li>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($_SESSION['user'] != $this->receita[0]['id_usuario']) : ?>
                                        <li class="list-group-item" id="salvarReceita" type="<?= (in_array($this->receita[0]['id_receita'],$this->receitas_salvas) ? "remove" : "add")  ?>" user="<?=$_SESSION['user']?>" identificacao="<?=$this->receita[0]['id_receita']?>">
                                        <?= (in_array($this->receita[0]['id_receita'],$this->receitas_salvas) ? "Remove Receita" : "Salva Receita")  ?></li>
                                    <?php endif; ?>

                                </ul>
                            </div>
                        </div>
                        <h1><?= $this->receita[0]['titulo'] ?></h1>
                        <hr>
                        <b>Categoria: </b><a href="<?= PROTOCOLO . "://" . PATH . "/categoria/show/" . $this->receita[0]['categoria'] ?>"> <?= $this->receita[0]['categoria'] ?></a><br>
                        <b>Criador: </b><a href="<?= PROTOCOLO . "://" . PATH . "/u/profile/" . $this->criador[0]['usuario'] ?>"> <?= $this->criador[0]['nome'] . ' ' . $this->criador[0]['sobrenome'] ?></a>
                        <br><br>
                        <h3>Ingredientes</h3>
                        <hr>

                        <?php foreach ($this->ingredientes as $i) :  ?>
                            <p><?= $i ?></p>
                        <?php endforeach; ?>
                        <br><br>
                        <h3>Modo de Fazer</h3>
                        <hr>
                        <div class="p-1">
                            <?= $this->receita[0]['mododefazer'] ?>
                        </div>
                        <br>
                    </div>

                </div>
            </div>
            <div class="col-md-5">
                <p id="msg-receita"></p>
            </div>
        </div>
    </div>
</div>