<!DOCTYPE html>
<html>
  <head>
    <script src="resources/js/jquery-3.2.1.min.js"></script>
    <script src="resources/js/bootstrap.bundle.min.js"></script>
	<script src="resources/js/tinymce/tinymce.min.js"></script>	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notepad</title>
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
	<link rel="stylesheet" href="resources/css/app.css">
	<!-- DataTables -->
	<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="resources/font-awesome-4.7.0/css/font-awesome.min.css">    
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#">Notepad</a>
		<?php if (isset($_SESSION['pwd'])) { ?>
		  <a class="nav-link" href="?accion=logout" title="Logout"><button class="navbar-toggler" type="button">
			<i class="fa fa-sign-out"></i>
		  </button></a>
		  <div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav ml-auto">
			  <li class="nav-item">
				<a class="nav-link" href="?accion=logout" title="Logout"><i class="fa fa-sign-out"></i></a>
			  </li>
			</ul>
		  </div>
		<?php } ?>
    </nav>
	<div class="container">
		<h1>Notepad</h1>  
		<hr>
		<!-- Main content -->
		<?php include_once($layout); ?>
		<!-- /.content -->
	</div>	
	<hr>
	<!-- Main Footer -->
	<footer class="main-footer">
		<!-- To the right -->
		<div class="pull-right hidden-xs">
		  <strong>Copyright &copy; 2017 <a href="http://www.oscaraviles.com">Oscar Aviles Miramontes</a>.</strong> All rights reserved.
		</div>
	</footer>		
<script>
//TinyMCE Init
tinymce.init({selector: "#texto",plugins: "image", remove_linebreaks: true});
//DataTables Init
$(document).ready( function () {
    $('#table-main').DataTable();
} );
</script>		 
  </body>
</html>
