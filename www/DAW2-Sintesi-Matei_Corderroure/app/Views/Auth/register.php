<?= $this->extend($config->viewLayout) ?>
<?= $this->section('main') ?>

<div class="container">
    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            <div class="card">
                <h2 class="card-header"><?= lang('Auth.register') ?></h2>
                <div class="card-body">

                    <?= view('App\Auth\_message_block') ?>

                    <form action="<?= route_to('register') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="form-group">
                            <label for="email"><?= lang('Auth.email') ?></label>
                            <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                            <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                        </div>

                        <div class="form-group">
                            <label for="username"><?= lang('Auth.username') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                        </div>

                        <div class="form-group">
                            <label for="name"><?= lang('Auth.name') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" name="name" placeholder="<?= lang('Auth.name') ?>" value="<?= old('name') ?>">
                        </div>

                        <div class="form-group">
                            <label for="surname"><?= lang('Auth.surname') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.surname')) : ?>is-invalid<?php endif ?>" name="surname" placeholder="<?= lang('Auth.surname') ?>" value="<?= old('surname') ?>">
                        </div>

                        <div class="form-group">
                            <label for="phone"><?= lang('Auth.phone') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.phone')) : ?>is-invalid<?php endif ?>" name="phone" placeholder="<?= lang('Auth.phone') ?>" value="<?= old('phone') ?>">
                        </div>

                        <div class="form-group">
                            <label for="city"><?= lang('Auth.city') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.city')) : ?>is-invalid<?php endif ?>" name="city" placeholder="<?= lang('Auth.city') ?>" value="<?= old('city') ?>">
                        </div>

                        <div class="form-group">
                            <label for="street"><?= lang('Auth.street') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.street')) : ?>is-invalid<?php endif ?>" name="street" placeholder="<?= lang('Auth.street') ?>" value="<?= old('street') ?>">
                        </div>

                        <div class="form-group">
                            <label for="postal_code"><?= lang('Auth.postal_code') ?></label>
                            <input type="text" class="form-control <?php if (session('errors.postal_code')) : ?>is-invalid<?php endif ?>" name="postal_code" placeholder="<?= lang('Auth.postal_code') ?>" value="<?= old('postal_code') ?>">
                        </div>

                        <div class="form-group">
                            <label for="file"><?= lang('Auth.img') ?></label>
                            <input type="file" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" name="file" placeholder="<?= lang('Auth.file') ?>" value="<?= old('file') ?>">
                        </div>

                        <div class="form-group">
                            <label for="password"><?= lang('Auth.password') ?></label>
                            <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
                            <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                        </div>

                        <br>

                        <button type="submit" class="btn btn-primary btn-block"><?= lang('Auth.register') ?></button>
                    </form>


                    <hr>

                    <p><?= lang('Auth.alreadyRegistered') ?> <a href="<?= route_to('login') ?>"><?= lang('Auth.signIn') ?></a></p>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>