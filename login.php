<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Uncle Bear's Power Tools - Login</title>

	<!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <?php include_once 'nav_bar.php';?>

    <div class="container-fluid">
		<div class="row">
            <?php
            session_start();
            if(isset($_SESSION['status']) && $_SESSION['status'] == 'failed'){ ?>
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-8">
                <div class="alert alert-danger" role="alert">Password Incorrect</div>
            </div>
            <?php } ?>
			<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
				<div class="page-header">
					<h2>Login</h2>
				</div>
				<form action="verify_login.php" method="post" class="form-horizontal">
                    <div class="form-group row">
                        <label for="staff_id" class="col-md-4 col-form-label text-md-right">Staff ID</label>
                        <div class="col-md-8">
                            <input id="staff_id" type="text" class="form-control" name="staff_id" required autocomplete="email" autofocus>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                        <div class="col-md-8">
                            <input id="password" type="password" class="form-control" name="password" required">
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type='submit' class="btn btn-primary" value='Login' style="margin:0px 14px;">
                    </div>
                </form>
            </div>
        </div>
    </div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>