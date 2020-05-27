<div class="background-img" style="background-image:url('<?=PROTOCOLO?>://<?=PATH?>/img/default/a.png')">
    <div class="profile-flex" >
        <div class="profile-img" style="background-image:url('<?=$dados[0]['foto_perfil']?>')" ></div>
        <h3><?=$_SESSION['nome_full']?></h3>
    </div>
    <a href="<?=PROTOCOLO?>://<?=PATH?>/usuario/edit/editar-perfil" class="perfil-edit">Editar Perfil</a>
</div>

<div class="container">
    <div class="nav-flex">
        <div class="nav-box">
            <h4>Minha Receitas<br></h4>
        </div>
        <div class="nav-box">
            <h4>Receitas <br> Salvas</h4>
        </div>
        <a href="<?=PROTOCOLO?>://<?=PATH?>/receita/cadastrarReceita">
            <div class="nav-box">
                <h4>Adicionar <br> Receita</h4>
            </div>
        </a>
    </div>
</div>


