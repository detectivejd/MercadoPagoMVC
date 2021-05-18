<h3><i class="fa fa-angle-right"></i>&nbsp;Editar Usuario nro <?php echo $usuario->getId(); ?></h3>
<form class="form-horizontal style-form" method="post" action="index.php?c=usuarios&a=edit&id=<?php echo \App\Session::get("id"); ?>&v=<?php echo \App\Session::get("v"); ?>">
    <div class="row mt">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="showback">
                <h4><i class="fa fa-angle-right"></i>&nbsp;Datos del Usuario:</h4>
                <input type="hidden" name="hid" value="<?php echo $usuario->getId(); ?>" />
                <div class="form-group">
                    <label class="col-sm-2 control-label">Username (*):</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtusername" class="form-control" autofocus="autofocus" required="required" tabindex="1" value="<?php echo $usuario->getUsername();?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Password (*):</label>
                    <div class="col-sm-10">
                        <input type="password" name="txtpassword" class="form-control" tabindex="2" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nombre (*):</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtnombre" class="form-control" required="required" tabindex="3" value="<?php echo $usuario->getNombre();?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Apellido:</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtapellido" class="form-control" tabindex="4" value="<?php echo $usuario->getApellido();?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="showback">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Correo (*):</label>
                    <div class="col-sm-10">
                        <input type="email" name="txtcorreo" class="form-control" tabindex="5" value="<?php echo $usuario->getCorreo();?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Celular:</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtcelular" class="form-control" tabindex="6" value="<?php echo $usuario->getCelular();?>" />
                    </div>
                </div>
                <div class="form-group">
                    <?php if(App\Session::get('log_in') == "administrador" and App\Session::get('log_id') != $usuario->getId()): ?>
                        <label class="col-sm-2 control-label">Rol (*):</label>
                    <?php endif; ?>
                    <div class="col-sm-10">
                        <div class = "tags-wrapper">
                            <?php if(App\Session::get('log_in') == "administrador" and App\Session::get('log_id') != $usuario->getId()): ?>
                                <input type="text" id="tags" name="rol" class="form-control" tabindex="7" value="<?php echo $usuario->getRol()->getNombre();?>" />
                            <?php else: ?>
                                <input type="hidden" name="rol" class="form-control" value="<?php echo $usuario->getRol()->getNombre();?>" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div style="text-align: center;">
                        <button type="submit" name="btnaceptar" value="Aceptar" class="btn btn-success" tabindex="4">
                            <i class="fa fa-check"></i>&nbsp;Aceptar
                        </button>
                        <?php 
                            $link = "index.php?c=usuarios&";
                            $link .= (App\Session::get('log_in') == "administrador" and App\Session::get('v') == 1) ? "a=index" : "a=view&id=".App\Session::get('log_id');
                        ?>
                        <a href="<?php echo $link; ?>">
                            <button type="button" name="btncancelar" value="Cancelar" class="btn btn-danger" tabindex="5">
                                <i class="fa fa-times"></i>&nbsp;Cancelar
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    var roles = [
        <?php foreach($roles as $rol): ?>
            "<?php echo $rol->getNombre(); ?>",
        <?php endforeach; ?>
    ];
    $("#tags").autocomplete({
        source: roles,
        minLength: 1,
        messages: {
            noResults: '',
            results: function() {}
        }
    });
</script>