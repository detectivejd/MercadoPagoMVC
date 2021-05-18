<h3><i class="fa fa-angle-right"></i>&nbsp;Productos de: <?php echo $usuario->getUsername(); ?></h3>
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
    <table class="table">
        <thead>
            <th scope="col"></th>
            <th scope="col">Fecha y Hora</th>
            <th scope="col">Producto</th>
            <th scope="col">Precio</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Imagen</th>
        </thead>
        <tbody>
            <?php
                $total = 0;
                foreach($historial as $h): 
            ?>
                    <tr>
                        <td>
                            <a href="index.php?c=historial&a=delete&idu=<?php echo $h->getUsuario()->getId(); ?>&idp=<?php echo $h->getProducto()->getId(); ?>&fecha=<?php echo $h->getFecha(); ?>" title="Borrar">
                                <i class="fa fa-times-circle" style="font-size: 22px;"></i>
                            </a>
                        </td>
                        <td><?php echo $h->getFecha(); ?></td>
                        <td><?php echo $h->getProducto()->getNombre(); ?></td>
                        <td><?php echo "$".number_format($h->getProducto()->getPrecio(), 0, ",", "."); ?></td>
                        <td><?php echo $h->getCantidad(); ?></td>
                        <td><?php echo "$".number_format($h->subTotal(), 0, ",", "."); ?></td>
                        <td>
                            <img src="<?php echo $h->getProducto()->getImagen(); ?>" style='width:50px; text-align: center;' />
                        </td>
                    </tr>
            <?php
                    $total += $h->subTotal(); 
                endforeach; 
            ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><strong>Total:</strong></td>
                <td><?php echo "$".number_format($total, 0, ",", "."); ?></td>
                <td></td>
            </tr>
        </tbody>      
    </table>
    <br />
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                        <i class="fa fa-angle-right"></i>&nbsp;<strong>Método de pago</strong>
                    </a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    <a href="index.php?c=pagos&a=pay&id=<?php echo $usuario->getId(); ?>">
                        <button type="submit" class="btn btn-info" name="btnmp">
                            <img src="Public/img/mercado pago.png" />
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>