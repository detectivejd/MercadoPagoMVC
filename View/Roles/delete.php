<h3><i class="fa fa-angle-right"></i>&nbsp;Borrar Producto</h3>
<form class="form-horizontal style-form" method="post" action="index.php?c=roles&a=delete&id=<?php echo \App\Session::get("id"); ?>">
    <div class="row mt">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="showback">
                <h4><i class="fa fa-angle-right"></i>&nbsp;¿Deseas eliminar el rol: <?php echo $rol->getNombre(); ?>?</h4>
                <br />
                <div style="text-align: center;">
                    <button type="submit" name="btnsip" class="btn btn-danger" tabindex="1">
                        <i class="far fa-thumbs-down"></i>&nbsp;Sí
                    </button>&nbsp;&nbsp;
                    <a href="index.php?c=roles&a=index">
                        <button type="button" name="btnnop"class="btn btn-success" tabindex="2">
                            <i class="far fa-thumbs-up"></i>&nbsp;No
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
