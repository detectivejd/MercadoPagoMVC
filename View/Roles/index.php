<h3><i class="fa fa-angle-right"></i>&nbsp;Gestión de Roles</h3>
<div class="content-panel">
    <div class="row">
        <div class="col-lg-2">
            <a href="index.php?c=main&a=index">
                <button class="btn btn-info" tabindex="1">
                    <i class="fa fa-arrow-left"></i>&nbsp;Volver
                </button>
            </a>
            <a href="index.php?c=roles&a=add">
                <button class="btn btn-success" tabindex="2">
                    <i class="fa fa-plus"></i>&nbsp;Crear
                </button>
            </a>
        </div>
    </div>
    <br />
    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <th></th>
            <th>ID</th>
            <th>Nombre</th>
        </thead>
        <tbody>
            <?php foreach($roles as $rol): ?>
                <tr>
                    <td>
                        <a href="index.php?c=roles&a=edit&id=<?php echo $rol->getId(); ?>" title="Editar">
                            <i class="fa fa-edit" style="font-size: 22px;"></i>
                        </a>&nbsp;
                        <a href="index.php?c=roles&a=delete&id=<?php echo $rol->getId(); ?>" title="Borrar">
                            <i class="fa fa-times-circle" style="font-size: 22px;"></i>
                        </a>
                    </td>
                    <td><?php echo $rol->getId(); ?></td>
                    <td><?php echo $rol->getNombre(); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>