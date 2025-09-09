<?php

use Illuminate\Support\Facades\DB;

$konf = DB::table('setting')->first();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title><?php echo e($konf->instansi_setting); ?> | Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo e($konf->tentang_setting); ?>">
	<meta name="keywords" content="<?php echo e($konf->keyword_setting); ?>">
	<meta name="author" content="<?php echo e($konf->instansi_setting); ?>">
	<meta name="robots" content="index, follow">
	<meta property="og:title" content="Login | <?php echo e($konf->instansi_setting); ?>">
	<meta property="og:description" content="<?php echo e($konf->tentang_setting); ?>">
	<meta property="og:image" content="<?php echo e(asset ('logo/'.$konf->logo_setting)); ?>">
	<meta property="og:url" content="<?php echo e(url()->current()); ?>">
	<meta name="twitter:card" content="summary_large_image">
	<link rel="icon" type="image/png" href="<?php echo e(asset ('logo/'.$konf->logo_setting)); ?>" />
	<link rel="stylesheet" type="text/css" href="web/login/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="web/login/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="web/login/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="web/login/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="web/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="web/login/css/main.css">
	<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "WebPage",
			"name": "Login | <?php echo e($konf->instansi_setting); ?>",
			"description": "AI Generalist & Technopreneur",
			"url": "<?php echo e(url()->current()); ?>"
		}
	</script>
</head>

<body>
	<div class="container-login100" style="background: url('<?php echo e(asset('web/login/images/11.jpg')); ?>') no-repeat center center; background-size: cover; background-attachment: fixed;">


		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100">
					<div class="login100-pic js-tilt" data-tilt>
						<img src="<?php echo e(asset ('logo/'.$konf->logo_setting)); ?>" alt="IMG">
					</div>

					<form action="<?php echo e(route('login')); ?>" method="POST">
						
						<?php echo csrf_field(); ?>
						<span class="login100-form-title">
							Login Page
						</span>

						<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
							<input class="input100" type="text" name="email" placeholder="Email" required>
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</span>
						</div>

						<div class="wrap-input100 validate-input" data-validate="Password is required">
							<input class="input100" type="password" name="password" placeholder="Password" required>
							<span class="focus-input100"></span>
							<span class="symbol-input100">
								<i class="fa fa-lock" aria-hidden="true"></i>
							</span>
						</div>

						<div class="container-login100-form-btn">
							<button class="login100-form-btn" type="submit">
								Login
							</button>
						</div>




					</form>
				</div>
			</div>
		</div>
	</div>
	
	<script src="web/login/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="web/login/vendor/bootstrap/js/popper.js"></script>
	<script src="web/login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="web/login/vendor/select2/select2.min.js"></script>
	<script src="web/login/vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="js/main.js"></script>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\ALI-PORTO\resources\views/auth/login.blade.php ENDPATH**/ ?>