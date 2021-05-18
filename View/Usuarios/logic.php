<?php $titulo = $usuario->getTocado() ? "Reactivar" : "Desactivar"; ?>
<h3><i class="fa fa-angle-right"></i>&nbsp;<?php echo $titulo ?> Usuario</h3>
<form class="form-horizontal style-form" method="post" action="index.php?c=usuarios&a=logic&id=<?php echo \App\Session::get("id"); ?>&v=<?php echo \App\Session::get("v"); ?>">
    <div class="row mt">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="showback">
                <?php 
                    strtolower($titulo);
                    $mensaje = "";
                    if(\App\Session::get("log_id") == $usuario->getId()): 
                        $mensaje = "¿Realmente deseas desactivar tu cuenta?";
                    else : 
                        $mensaje = "¿Deseas ".$titulo." el Usuario:".$usuario->getUsername()."?";
                    endif; 
                ?>
                <h4><i class="fa fa-angle-right"></i>&nbsp;<?php echo $mensaje; ?></h4>
                <br />
                <?php 
                    $sip = $usuario->getTocado() ? "btn btn-success" : "btn btn-danger";
                    $nop = $usuario->getTocado() ? "btn btn-info" : "btn btn-success";
                    $manos = $usuario->getTocado() ? "far fa-thumbs-up" : "far fa-thumbs-down";
                    $manon = $usuario->getTocado() ? "far fa-thumbs-down" : "far fa-thumbs-up";
                ?>
                <div style="text-align: center;">
                    <button type="submit" name="btnsip" class="<?php echo $sip; ?>" tabindex="1">
                        <i class="<?php echo $manos; ?>"></i>&nbsp;Sí
                    </button>&nbsp;&nbsp;
                    <?php 
                        $link = "index.php?c=usuarios&";
                        $link .= (App\Session::get('log_in') == "administrador" and App\Session::get('v')) ? "a=index" : "a=view&id=".App\Session::get('log_id');
                    ?>
                    <a href="<?php echo $link;?>">
                        <button type="button" name="btnnop" class="<?php echo $nop; ?>" tabindex="2">
                            <i class="<?php echo $manon; ?>"></i>&nbsp;No
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>