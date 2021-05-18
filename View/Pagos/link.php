<h3><i class="fa fa-angle-right"></i>&nbsp;Gestión de Usuarios sin pagar</h3>
<div class="content-panel">
    <div class="row">
        <div class="col-lg-2">
            <a href="index.php?c=main&a=index">
                <button class="btn btn-info" tabindex="1">
                    <i class="fa fa-arrow-left"></i>&nbsp;Volver
                </button>
            </a>
        </div>
    </div>
    <br />
    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <th></th>
            <th>Usuario</th>
            <th>Cantidad al carrito</th>
        </thead>
        <tbody>
            <?php foreach($filas as $fila): ?>
                <tr>
                    <td>
                        <a href="index.php?c=pagos&a=mail&id=<?php echo $fila["id"]; ?>" title="Enviar link de pago">
                            <i class="far fa-envelope" style="font-size: 22px;"></i>
                        </a>
                    </td>
                    <td><?php echo $fila["username"]; ?></td>
                    <td><i class="fas fa-shopping-cart"></i>&nbsp;<?php echo $fila["cantidad"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($paginador != null): ?>
        <div class="text-center">
        <ul class="pagination">
            <?php if($paginador['primero']): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo 'index.php?c=pagos&a=link&id='.App\Session::get("id").'&p=' . $paginador['primero']; ?>" title="Primero">
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
                    <a class="page-link" href="<?php echo 'index.php?c=pagos&a=link&id='.App\Session::get("id").'&p=' . $paginador['anterior']; ?>" title="Anterior">
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
                        <a href="<?php echo "index.php?c=pagos&a=link&id=".App\Session::get("id")."&p=" . $paginador['rango'][$i]; ?>">
                            <?php echo $paginador['rango'][$i]; ?>
                        </a>
                    </li>
                <?php endif;
            endfor;
            if($paginador['siguiente']): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo 'index.php?c=pagos&a=link&id='.App\Session::get("id").'&p=' . $paginador['siguiente']; ?>" title="Siguiente">
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
                    <a class="page-link" href="<?php echo 'index.php?c=pagos&a=link&id='.App\Session::get("id").'&p=' . $paginador['ultimo']; ?>" title="Último">
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