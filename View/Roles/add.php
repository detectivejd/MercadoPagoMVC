<h3><i class="fa fa-angle-right"></i>&nbsp;Crear Rol</h3>
<form class="form-horizontal style-form" method="post" action="index.php?c=roles&a=add">
    <div class="row mt">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="showback">
                <h4><i class="fa fa-angle-right"></i>&nbsp;Datos del Rol:</h4>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nombre (*):</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtnombre" class="form-control" autofocus="autofocus" tabindex="1"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt">
        <div style="text-align: center;">
            <button type="submit" name="btnaceptar" value="Aceptar" class="btn btn-success" tabindex="2">
                <i class="fa fa-check"></i>&nbsp;Aceptar
            </button>
            <a href="index.php?c=roles&a=index">
                <button type="button" name="btncancelar" value="Cancelar" class="btn btn-danger" tabindex="3">
                    <i class="fa fa-times"></i>&nbsp;Cancelar
                </button>
            </a>
        </div>
    </div>
</form>