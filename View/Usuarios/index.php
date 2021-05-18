<h3><i class="fa fa-angle-right"></i>&nbsp;Gestión de Usuarios</h3>
<div class="content-panel">
    <div class="row">
        <div class="col-lg-2">
            <a href="index.php?c=main&a=index">
                <button class="btn btn-info" tabindex="1">
                    <i class="fa fa-arrow-left"></i>&nbsp;Volver
                </button>
            </a>
            <a href="index.php?c=usuarios&a=add">
                <button class="btn btn-success" tabindex="2">
                    <i class="fa fa-plus"></i>&nbsp;Crear
                </button>
            </a>
        </div>
        <div class="col-lg-6">
            <form name="frmsearch" method="post" action="index.php?c=usuarios&a=index">
                <div class="input-group">
                    <input type="search" name="txtbuscador" placeholder="Buscar por username, por nombre o rol" class="form-control" tabindex="3" autofocus="autofocus" />
                    <span class="input-group-btn">
                        <button onclick="frmsearch.submit();" name="btnsearch" class="btn btn-info" tabindex="4">
                            <i class="fas fa-search"></i>&nbsp;Buscar
                        </button>
                    </span>                   
                </div>
            </form>
        </div>                        
    </div>
    <br />        
    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <th></th>
            <th>ID</th>
            <th>Username</th>
            <th>Nombre Completo</th>
            <th>Rol</th>
            <th>¿Tocado?</th>
        </thead>
        <tbody>
            <?php foreach($usuarios as $usuario): ?>
                <tr>
                    <td>
                        <a href="index.php?c=usuarios&a=edit&id=<?php echo $usuario->getId(); ?>&v=1" title="Editar">
                            <i class="fa fa-edit" style="font-size: 22px;"></i>
                        </a>&nbsp;
                        <a href="index.php?c=usuarios&a=logic&id=<?php echo $usuario->getId(); ?>&v=1" title="Borrar">
                            <?php $tocado = $usuario->getTocado() ? "fas fa-toggle-off" : "fas fa-toggle-on"; ?>
                            <i class="<?php echo $tocado; ?>" style="font-size: 22px;"></i>
                        </a>
                    </td>
                    <td><?php echo $usuario->getId(); ?></td>
                    <td><?php echo $usuario->getUsername(); ?></td>
                    <td><?php echo $usuario->nombreCompleto(); ?></td>
                    <td><?php echo $usuario->getRol()->getNombre(); ?></td>
                    <td><?php echo $usuario->getTocado() ? "Sí" : "No"; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($paginador != null): ?>
        <div class="text-center">
            <ul class="pagination">
                <?php if($paginador['primero']): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'index.php?c=usuarios&a=index&p=' . $paginador['primero']; ?>" title="Primero">
                            <i class="fas fa-angle-double-left">&nbsp;</i>
                        </a>
                    </li>                            
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class ="page-link">
                            <i class="fas fa-angle-double-left">&nbsp;</i>
                        </span>                        
                    </li>
                <?php endif; ?>
                <?php if($paginador['anterior']): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'index.php?c=usuarios&a=index&p=' . $paginador['anterior']; ?>" title="Anterior">
                            <i class="fas fa-angle-left">&nbsp;</i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class ="page-link">
                            <i class="fas fa-angle-left">&nbsp;</i>
                        </span>                        
                    </li>
                <?php endif; 
                for($i = 0; $i < count($paginador['rango']); $i++):
                    if($paginador['actual'] == $paginador['rango'][$i]): ?>
                        <li class="active">
                            <span><?php echo $paginador['rango'][$i]; ?></span>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="<?php echo "index.php?c=usuarios&a=index&p=" . $paginador['rango'][$i]; ?>">
                                <?php echo $paginador['rango'][$i]; ?>
                            </a>
                        </li>
                    <?php endif;
                endfor;
                if($paginador['siguiente']): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'index.php?c=usuarios&a=index&p=' . $paginador['siguiente']; ?>" title="Siguiente">
                            <i class="fas fa-angle-right">&nbsp;</i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class ="page-link">
                            <i class="fas fa-angle-right">&nbsp;</i>
                        </span>                        
                    </li>
                <?php endif; 
                if($paginador['ultimo']): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'index.php?c=usuarios&a=index&p=' . $paginador['ultimo']; ?>" title="Último">
                            <i class="fas fa-angle-double-right">&nbsp</i>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class ="page-link">
                            <i class="fas fa-angle-double-right">&nbsp;</i>
                        </span>                        
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>