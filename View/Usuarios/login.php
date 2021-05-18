<style>
	.login-form {
		width: 340px;
    	margin: 50px auto;
	}
    .login-form form {
    	margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .login-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
</style>
<div class="login-form">
    <form class="form-horizontal style-form" method="post" action="index.php?c=usuarios&a=login">
        <h2 class="text-center">Iniciar Sesion</h2>
        <div class="form-group">
            <input type="text" name="txtusername" class="form-control" placeholder="Username" tabindex="1" />
        </div>
        <div class="form-group">
            <input type="password" name="txtpassword" class="form-control" placeholder="Password" tabindex="2" />
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block" name="btnaceptar">
                <i class="fas fa-sign-in-alt"></i>&nbsp;Aceptar            
            </button>
        </div>
    </form>
    <p class="text-center">
        <a href="index.php?c=usuarios&a=add">
            <i class="fas fa-user"></i>&nbsp;Crear cuenta
        </a>
    </p>
</div>