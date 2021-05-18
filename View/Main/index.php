<div class="row">    
    <?php foreach($productos as $producto): ?>
        <form action="index.php?c=historial&a=add&idp=<?php echo $producto->getId(); ?>" method="post">
        <div class="col-md-3">
            <div class="thumbnail" style="text-align: center;border: 1px solid #ece; margin: 10px 0px;">
                <img src="<?php echo $producto->getImagen(); ?>" style="width: 150px; height: 100px;">
                <div class="caption">
                    <h3><?php echo $producto->getNombre(); ?></h3>
                    <p>
                        <?php echo "$".number_format($producto->getPrecio(), 0, ",", "."); ?>
                    </p>
                    <p>                       
                        <input min="1" max="50" value="1" name="txtcantidad" type="number">
                    </p>                  
                    <a href="">
                        <button class="btn btn-primary">
                            <i class="fas fa-cart-plus"></i>&nbsp;Comprar
                        </button>
                    </a>
                    
                </div>
            </div>
        </div>
        </form>
    <?php endforeach; ?>
</div>
<?php if ($paginador != null): ?>
        <div class="text-center">
        <ul class="pagination">
            <?php if($paginador['primero']): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo 'index.php?c=main&a=index&p=' . $paginador['primero']; ?>" title="Primero">
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
                    <a class="page-link" href="<?php echo 'index.php?c=main&a=index&p=' . $paginador['anterior']; ?>" title="Anterior">
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
                        <a href="<?php echo "index.php?c=main&a=index&p=" . $paginador['rango'][$i]; ?>">
                            <?php echo $paginador['rango'][$i]; ?>
                        </a>
                    </li>
                <?php endif;
            endfor;
            if($paginador['siguiente']): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo 'index.php?c=main&a=index&p=' . $paginador['siguiente']; ?>" title="Siguiente">
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
                    <a class="page-link" href="<?php echo 'index.php?c=main&a=index&p=' . $paginador['ultimo']; ?>" title="Último">
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
