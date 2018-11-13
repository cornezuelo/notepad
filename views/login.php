<div class="container">
  <div class="container">
	<p class="login-box-msg">Login inserting your password</p>
	<form action="index.php?accion=login" method="post">          
<?php if (isset($config['recaptchaPublicKey']) && !empty($config['recaptchaPublicKey'])) { ?>
		<div class="g-recaptcha" data-sitekey="<?php echo $config['recaptchaPublicKey']; ?>"></div>
<?php } ?>	
	  <div class="form-group has-feedback">
		<input type="password" name="password" class="form-control" placeholder="Password">
		<span class="glyphicon glyphicon-lock form-control-feedback"></span>
	  </div>
	  <div class="container">
		<div class="col-xs-8">
			<?php if (isset($flag_pwd)) { ?>
			<div align="center"><p style="color:red"><b>The password is wrong</b></p></div>
			<?php } ?>
		</div><!-- /.col -->
		<div class="col-xs-4">
		  <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
		</div><!-- /.col -->
	  </div>
	</form>
  </div>
</div>
