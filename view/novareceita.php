

<?php if(isset($_SESSION["ERROR_DATA_OUT"])): ?>

<div class="alert alert-dark" role="alert">
 <?php echo $_SESSION["ERROR_DATA_OUT"]; ?>
 
</div>

<?php 

unset($_SESSION["ERROR_DATA_OUT"]);
endif;
?>
<br><br>
<div class="container">
    <div class="categoria-content">
        <div class="col-md-8 offset-md-2 col-sm-12 col-12">
           <form action="<?=PROTOCOLO?>://<?=PATH?>/receita/validarnovareceita" method="post" id="formNewReceita" enctype="multipart/form-data"  class="form-add-categoria">
               <div class="form-group">
                   <h3>Nome da Receita</h3>
                   <input type="text" class="form-control" name="nomeReceita" autocomplete="off" required placeholder="Nome da Receita">
                </div>
               <div class="form-group">
                   <h3>Ingredientes</h3>
                   <textarea class="form-control" id="text-ingredientes" rows="5" placeholder="Um ingrediente por linha"required ></textarea>
                   <input type="hidden" name="ingredientes" id="listasFull">
               </div>
               <br><br>
               <div class="form-group">
                   <h3>Modo de Fazer</h3>
                   <textarea class="form-control" name="descricao"  rows="5" required placeholder="Modo de Fazer"></textarea>
               </div>
               <div class="form-group">
                   <h3>Categoria</h3>
                   <select name="categoria" class="form-control">
                       <?php 
                            $database = ReceitaController::getConnect();
                            $categorias = $database->query("SELECT * FROM CATEGORIA");
                            foreach($categorias as $categoria => $value):
                       ?>
                        <option value="<?=$value['nome_categoria']?>"><?=$value['nome_categoria']?></option>

                            <?php endforeach;?>
                   </select>
               </div>

               <div class="form-group">
                   <h3>Imagem</h3>
                   <img  id="imagemReceita" width="200px" height="200px" />
                   <input type="file" name="fotoReceita" accept="image/*" id="fotoReceita" required />
                   <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
               </div>

               <div class="form-group">
                   <input type="submit" value="Adicionar" class="btn btn-success">
                   <input type="reset" value="Limpa" class="btn btn-danger">
               </div>
               
           </form>
        </div>
    </div>
</div>