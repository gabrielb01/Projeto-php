<br><br>
<div class="container">
    <div class="row">
        <a href="<?= PROTOCOLO ?>://<?= PATH ?>/categoria/new">
            <button class="btn btn-primary">Cadastrar categoria</button>
        </a>
    </div>
    <br><br>
    <div class="categoria-content">
        <table class="table table-striped">
            <thead>
                <th>Nome</th>
                <th>Descrição</th>
                <th>editar / excluir</th>
            </thead>
            <tbody>
                <?php
                    $database = $this->database;
                    $resultado = $database->query("SELECT * FROM CATEGORIA");
                    foreach ($resultado as $value):                
                ?>
                <tr>
                    <td><?=$value['nome_categoria']?></td>
                    <td><?=$value['descricao']?></td>
                    <td><a href="<?=PROTOCOLO?>://<?=PATH?>/categoria/edit/<?=$value['id_categoria']?>"><i class="fas fa-edit"></i></a>  / <i class="fas fa-trash" id="trash" name="<?=$value['id_categoria']?>"></i></td>
                </tr>


                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>