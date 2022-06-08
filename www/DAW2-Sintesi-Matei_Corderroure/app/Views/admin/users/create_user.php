<?= view('App\layouts\layout_admin') ?>

<style type="text/css">
    a {
        padding-left: 5px;
        padding-right: 5px;
        margin-left: 5px;
        margin-right: 5px;
    }

    .pagination li.active {
        background: deepskyblue;
        color: white;
    }

    .pagination li.active a {
        color: white;
        text-decoration: none;
    }
</style>

<body>
    <div class='container' style='margin-top: 20px;'>

        <h2>Create User</h2></br>
        <form id="createUser">
            <div class="form-group">
                <label for="email"><?= lang('Auth.email') ?></label>
                <input type="email" id="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
            </div>

            <div class="form-group">
                <label for="username"><?= lang('Auth.username') ?></label>
                <input type="text" id="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
            </div>

            <div class="form-group">
                <label for="name"><?= lang('Auth.name') ?></label>
                <input type="text" id="name" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" name="name" placeholder="<?= lang('Auth.name') ?>" value="<?= old('name') ?>">
            </div>

            <div class="form-group">
                <label for="surname"><?= lang('Auth.surname') ?></label>
                <input type="text" id="surname" class="form-control <?php if (session('errors.surname')) : ?>is-invalid<?php endif ?>" name="surname" placeholder="<?= lang('Auth.surname') ?>" value="<?= old('surname') ?>">
            </div>

            <div class="form-group">
                <label for="phone"><?= lang('Auth.phone') ?></label>
                <input type="text" id="phone" class="form-control <?php if (session('errors.phone')) : ?>is-invalid<?php endif ?>" name="phone" placeholder="<?= lang('Auth.phone') ?>" value="<?= old('phone') ?>">
            </div>

            <div class="form-group">
                <label for="city"><?= lang('Auth.city') ?></label>
                <input type="text" id="city" class="form-control <?php if (session('errors.city')) : ?>is-invalid<?php endif ?>" name="city" placeholder="<?= lang('Auth.city') ?>" value="<?= old('city') ?>">
            </div>

            <div class="form-group">
                <label for="street"><?= lang('Auth.street') ?></label>
                <input type="text" id="street" class="form-control <?php if (session('errors.street')) : ?>is-invalid<?php endif ?>" name="street" placeholder="<?= lang('Auth.street') ?>" value="<?= old('street') ?>">
            </div>

            <div class="form-group">
                <label for="postal_code"><?= lang('Auth.postal_code') ?></label>
                <input type="text" id="postal_code" class="form-control <?php if (session('errors.postal_code')) : ?>is-invalid<?php endif ?>" name="postal_code" placeholder="<?= lang('Auth.postal_code') ?>" value="<?= old('postal_code') ?>">
            </div>

            <div class="form-group">
                <label for="file"><?= lang('Auth.img') ?></label>
                <input type="file" id="userfile" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" name="userfile" placeholder="<?= lang('Auth.file') ?>" value="<?= old('file') ?>">
            </div>

            <div class="form-group">
                <label for="password"><?= lang('Auth.password') ?></label>
                <input type="password" id="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
                <input type="password" id="pass_confirm" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
            </div>

            <div id="message"></div></br>
            <input class="btn btn-primary" type="submit" value="Enviar">

        </form>
    </div>

</body>

</html>

<script>
    createUser.onsubmit = async (e) => {
        e.preventDefault();
        formRegistration = new FormData(createUser);

        var requestOptions = {
            method: 'POST',
            body: formRegistration
        };

        fetch("<?php echo base_url(); ?>/api/register", requestOptions)
            .then(response => response.json())
            .then((data) => {
                if (data.status == 200) {
                    document.getElementById("message").innerHTML = "";
                    document.getElementById("message").innerHTML = "Message: " + data.messages;
                } else {
                    document.getElementById("message").innerHTML = "";
                    document.getElementById("message").innerHTML = "Error: " + data.messages;
                }
            }).catch(error => {
                alert("Unexpected error");
            });
    }
</script>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?= base_url('js/jquery-1.10.2.min.js') ?>"> </script>
<script type="text/javascript" src="<?= base_url('js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/jquery-1.10.2.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/jquery.mixitup.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/main.js') ?>"></script>