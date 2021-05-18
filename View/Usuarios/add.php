<h3><i class="fa fa-angle-right"></i>&nbsp;Crear Usuario</h3>
<form class="form-horizontal style-form" method="post" action="index.php?c=usuarios&a=add">
    <div class="row mt">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="showback">
                <h4><i class="fa fa-angle-right"></i>&nbsp;Datos del Usuario:</h4>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Username (*):</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtusername" class="form-control" autofocus="autofocus" required="required" tabindex="1" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Password (*):</label>
                    <div class="col-sm-10">
                        <input type="password" name="txtpassword" class="form-control" required="required" tabindex="2" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nombre (*):</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtnombre" class="form-control" required="required" tabindex="3" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Apellido:</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtapellido" class="form-control" tabindex="4" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="showback">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Correo (*):</label>
                    <div class="col-sm-10">
                        <input type="email" name="txtcorreo" class="form-control" tabindex="5" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Celular:</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtcelular" class="form-control" tabindex="6" />
                    </div>
                </div>
                <div class="form-group">
                    <?php if(App\Session::get('log_in') != null): ?>
                        <label class="col-sm-2 control-label">Rol (*):</label>
                    <?php endif; ?>
                    <div class="col-sm-10">
                        <div class = "tags-wrapper">
                            <?php if(App\Session::get('log_in') != null): ?>
                                <input type="text" id="tags" name="rol" class="form-control" tabindex="7" />
                            <?php else: ?>
                                <input type="hidden" name="rol" class="form-control" value="usuario" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div style="text-align: center;">
                        <button type="submit" name="btnaceptar" value="Aceptar" class="btn btn-success" tabindex="8">
                            <i class="fa fa-check"></i>&nbsp;Aceptar
                        </button>
                        <?php 
                            $link = "index.php?";
                            $link .= (App\Session::get('log_in') != null) ? "c=usuarios" : "c=main";
                            $link .= "&a=index";
                        ?>
                        <a href="<?php echo $link; ?>">
                            <button type="button" name="btncancelar" value="Cancelar" class="btn btn-danger" tabindex="9">
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