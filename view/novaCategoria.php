
<?php if(isset($_SESSION["ERROR_DATA_OUT"])): ?>

<div class="alert alert-dark" role="alert">
 <?php echo $_SESSION["ERROR_DATA_OUT"]; ?>
 
</div>

<?php 

unset($_SESSION["ERROR_DATA_OUT"]);

endif;
?>
<div class="container">
    <div class="categoria-content">
        <div class="col-md-8 offset-md-2 col-sm-12 col-12">
           <form action="<?=PROTOCOLO?>://<?=PATH?>/categoria/validarnovacategoria" method="post" class="form-add-categoria">
               <div class="form-group">
                   <h3>Nome da Categora</h3>
                   <input type="text" class="form-control" name="categoria" autocomplete="off" required>
                </div>
               <div class="form-group">
                   <h3>Descrição</h3>
                   <textarea class="form-control" name="descricao" required   rows="5"></textarea>
               </div>
               <br><br>
               <div class="form-group">
                   <input type="submit" value="Adicionar" class="btn btn-success">
                   <input type="reset" value="Limpa" class="btn btn-danger">
               </div>
           </form>
        </div>
    </div>
</div>