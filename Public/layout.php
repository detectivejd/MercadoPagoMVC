<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <link rel="icon" href="Public/img/logo-mywebsite-urian-viera.svg">
        <link href="Public/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="Public/css/all.css" rel="stylesheet" type="text/css" />
        <link href="Public/css/jquery-ui.css" rel="stylesheet" type="text/css" />
        <link href="Public/css/app.css" rel="stylesheet" type="text/css" />
        <script src="Public/js/jquery.js" type="text/javascript"></script>
        <script src="Public/js/popper.js" type="text/javascript"></script>
        <script src="Public/js/bootstrap.js"></script>
        <script src="Public/js/all.js" type="text/javascript"></script>
        <script src="Public/js/jquery-ui.js" type="text/javascript"></script>        
        <title>Probando Mercado Pago</title>
    </head>
    <body>
        <?php echo $menu; ?>
        <section>
            <div id="main">
                <?php
                    if (\App\Session::get('msg')!=null) {  ?>
                        <div class="alert alert-<?php echo \App\Session::get('msg')[0]; ?> fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                            <i class="fa fa-<?php echo \App\Session::get('msg')[1]; ?>" style="font-size: 24px;"></i>&nbsp;
                            <?php echo \App\Session::get('msg')[2]; ?>
                        </div>                        
                <?php    
                        \App\Session::set('msg', "");                     
                    } 
                    echo $content;        
                ?>
            </div>
        </section>        
    </body>
</html>