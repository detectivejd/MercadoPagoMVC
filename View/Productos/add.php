<h3><i class="fa fa-angle-right"></i>&nbsp;Crear Producto</h3>
<form class="form-horizontal style-form" method="post" enctype="multipart/form-data" action="index.php?c=productos&a=add">
    <div class="row mt">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="showback">
                <h4><i class="fa fa-angle-right"></i>&nbsp;Datos del Producto:</h4>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Nombre (*):</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtnombre" class="form-control" autofocus="autofocus" required="required" tabindex="1"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Precio (*):</label>
                    <div class="col-sm-10">
                        <input type="text" name="txtprecio" class="form-control" required="required" tabindex="2"/>
                    </div>
                </div>
                <div class="form-group">
                <label class="col-sm-2 control-label">Imagen:</label>
                    <div class="col-sm-10">
                    <input type="file" name="fimagen" class="file" accept="image/*">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" disabled placeholder="Subir Imagen" id="file">
                            <div class="input-group-btn">
                                <button type="button" class="browse btn btn-primary" tabindex="3">
                                    <i class="fas fa-upload"></i>&nbsp;Subir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">            
            <div class="ml-2 col-sm-6">
                <img src="Public/img/icons8-image-64.png" id="preview" class="img-thumbnail" name="imagen">
            </div>
        </div>        
    </div>
    <div class="row mt">
        <div style="text-align: center;">
            <button type="submit" name="btnaceptar" value="Aceptar" class="btn btn-success" tabindex="4">
                <i class="fa fa-check"></i>&nbsp;Aceptar
            </button>
            <a href="index.php?c=productos&a=index">
                <button type="button" name="btncancelar" value="Cancelar" class="btn btn-danger" tabindex="5">
                    <i class="fa fa-times"></i>&nbsp;Cancelar
                </button>
            </a>
        </div>
    </div>
</form>
<style>
    .file {
        visibility: hidden;
        position: absolute;
    }
</style>
<script>
    $(document).on("click", ".browse", function() {
        var file = $(this).parents().find(".file");
        file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $("#file").val(fileName);
        var reader = new FileReader();
        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });
</script>