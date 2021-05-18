<h3><i class="fa fa-angle-right"></i>&nbsp;Ver Usuario nro <?php echo $usuario->getId(); ?></h3>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                    <i class="fa fa-angle-right"></i>&nbsp;Datos del Usuario:&nbsp;&nbsp;<?php echo $usuario->getUsername(); ?>
                </a>
            </h4>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">
                <table class="table table-striped">
                    <tr>
                        <td><strong>Nombre:</strong>&nbsp;&nbsp;<?php echo $usuario->getNombre(); ?></td>
                        <td><strong>Apellido:</strong>&nbsp;&nbsp;<?php echo $usuario->getApellido(); ?></td>
                        <td><strong>Correo:</strong>&nbsp;&nbsp;<?php echo $usuario->getCorreo(); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Celular:</strong>&nbsp;&nbsp;<?php echo $usuario->getCelular(); ?></td>
                        <td colspan="2"><strong>Rol:</strong>&nbsp;&nbsp;<?php echo $usuario->getRol()->getNombre(); ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                    <i class="fa fa-angle-right"></i>&nbsp;Editar tu Usuario
                </a>
            </h4>
        </div>
        <div id="collapse2" class="panel-collapse collapse">
            <div class="panel-body">
                <a href="index.php?c=usuarios&a=edit&id=<?php echo $usuario->getId(); ?>&v=0">
                    <button class="btn btn-info" tabindex="2">
                        <i class="fa fa-edit"></i>&nbsp;Editar
                    </button>
                </a>
            </div>
        </div>
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                    <i class="fa fa-angle-right"></i>&nbsp;Borrar tu Usuario
                </a>
            </h4>
        </div>
        <div id="collapse3" class="panel-collapse collapse">
            <div class="panel-body">
                <a href="index.php?c=usuarios&a=logic&id=<?php echo $usuario->getId(); ?>&v=0">
                    <button class="btn btn-danger" tabindex="2">
                        <i class="fa fa-times-circle"></i>&nbsp;Borrar
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>