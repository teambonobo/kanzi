<?php 
if(isset($_GET['login'])){ 
    if($_GET['login'] == 'failed'){ 
        define('ERROR', 'true'); 
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="css/bootstrap-responsive.css" type="text/css">
<link rel="stylesheet" href="css/styles.css" type="text/css">
</head>

<body>
	<header class="header">	
    	<div class="navbar navbar-fixed-top">
        	<div class="navbar-inner">
        		<div class="container-fluid txtcenter">
                	<a class="brand fnone" href="#"><img src="img/Bonobo_logo.png"/></a>
                </div>
            </div>
        </div>
   	</header>
   	<section class="formDiv">
    	<form name="Login" class="form-horizontal" method="post" action="./auth/auth.php">
        	<div class="txtcenter">
            	<div class="control-group <?php if(ERROR == 'true') echo "error"; ?>">
                        <?php
                            if(ERROR == 'true')
                                echo "<span class=\"help-inline\">Invalid User Name/Password</span>";
                            ?>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span>
                            <input type="text" placeholder="User Name" name="id">
                        </div>
                    </div>
               </div>
                
                <div class="control-group <?php if(ERROR == 'true') echo "error"; ?>" >
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span>
                            <input type="password" placeholder="Password" name="password">
                        </div>
                    </div>
                </div>
                
                <div class="control-group">
                  	<div class="controls">
                    	<button type="submit" class="btn btn-primary btn-custom">Sign in</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
    
    <footer class="footer">
    	<div class="txtcenter">
    		<div>Designed and Powered by <a href="#">Bonobo</a></div>
        	<div>&copy;2013 Bonobo. All rights reserved. </div>
        </div>
    </footer>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/placeholder.js"></script>
</body>
</html>
