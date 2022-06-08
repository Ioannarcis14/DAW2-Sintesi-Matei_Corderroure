<?= $this->extend($config->viewLayout) ?>

<?= $this->section('main') ?>

<div class="container">
	<div class="row">
		<div class="col-sm-6 offset-sm-3">

			<div class="card">
				<h2 class="card-header"><?=lang('Auth.loginTitle')?></h2>
				<div class="card-body">

					<?= view('App\Auth\_message_block') ?>

					<form action="<?= route_to('login') ?>" method="post">
						<?= csrf_field() ?>

<?php if ($config->validFields === ['email']): ?>
						<div class="form-group">
							<label for="login"><?=lang('Auth.email')?></label>
							<input type="email" class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
								   name="login" placeholder="<?=lang('Auth.email')?>">
							<div class="invalid-feedback">
								<?= session('errors.login') ?>
							</div>
						</div>
<?php else: ?>
						<div class="form-group">
							<label for="login"><?=lang('Auth.emailOrUsername')?></label>
							<input type="text" class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>"
								   name="login" placeholder="<?=lang('Auth.emailOrUsername')?>">
							<div class="invalid-feedback">
								<?= session('errors.login') ?>
							</div>
						</div>
<?php endif; ?>

						<div class="form-group">
							<label for="password"><?=lang('Auth.password')?></label>
							<input type="password" name="password" class="form-control  <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?=lang('Auth.password')?>">
							<div class="invalid-feedback">
								<?= session('errors.password') ?>
							</div>
						</div>

<?php if ($config->allowRemembering): ?>
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox" name="remember" class="form-check-input" <?php if(old('remember')) : ?> checked <?php endif ?>>
								<?=lang('Auth.rememberMe')?>
							</label>
						</div>
<?php endif; ?>

						<br>

						<button type="submit" class="btn btn-primary btn-block"><?=lang('Auth.loginAction')?></button>
					</form>

					<hr>

<?php if ($config->allowRegistration) : ?>
					<p><a href="<?= route_to('register') ?>"><?=lang('Auth.needAnAccount')?></a></p>
<?php endif; ?>
				</div>
			</div>

		</div>
	</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/jquery-1.10.2.min.js"> </script>
<script type="text/javascript" src="js/bootstrap.min.js" ></script>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery.mixitup.min.js" ></script>
<script type="text/javascript" src="js/main.js" ></script>
<script>
        window.sessionStorage.removeItem("tokenRefresh");
</script>

<?= $this->endSection() ?>
