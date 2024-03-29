<!doctype html>
<html lang="en" class="profile">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
    <?= view('App\layouts\header') ?>

    <?= link_tag('css/styles.css'); ?>
    <title>Restaurant</title>
    <style>

    </style>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>

<body class="profile">

    <?= view('App\layouts\_navbar') ?>

    <div role="main" class="p_main">

        <div class="imgContainer" style="margin: 50px; background-color: white">
            <b>Profile Picture:</b>
            <?php
            if ($user->img_profile == null) {
                echo img(base_url('/img/dish.jpg'));
            } else {
                echo '<img src="'.base_url("/fileget").'/'. $user->img_profile . '" alt="image">';
            }
            ?>

        </div>

        <div class="dataContainer" style="margin: 50px; background-color: white">
            <?php
            echo "<ul class='list-group infoList'>";
            echo "<li class=list-group-item> <b>Username: </b>" . $user->username . "</li>";
            echo "<li class=list-group-item> <b>Email: </b>" . $user->email . "</li>";
            echo "<li class=list-group-item> <b>Name: </b>" . $user->name . "</li>";
            echo "<li class=list-group-item> <b>Surname: </b>" . $user->surname . "</li>";
            echo "<li class=list-group-item> <b>Phone: </b>" . $user->phone . "</li>";
            echo "<li class=list-group-item> <b>City: </b>" . $user->city . "</li>";
            echo "<li class=list-group-item> <b>Street: </b>" . $user->street . "</li>";
            echo "<li class=list-group-item> <b>Postal Code: </b>" . $user->postal_code . "</li>";
            echo "</ul>";
            ?>
        </div>

        <div class="functionContainers">
            <div class="container" style="background-color: white">
                <h2 style="padding-bottom: 50px">Change your data</h2>
                <form id="formUpdate" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="email"><?= lang('Auth.newEmail') ?></label>
                        <input type="email" id="email" class="form-control <?php if (session('errors.newEmail')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.newEmail') ?>" value="<?= $user->email ?>">
                    </div>

                    <div class="form-group">
                        <label for="username"><?= lang('Auth.newUsername') ?></label>
                        <input type="text" id="username" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.newUsername') ?>" value="<?= $user->username ?>">
                    </div>

                    <div class="form-group">
                        <label for="name"><?= lang('Auth.newName') ?></label>
                        <input type="text" id="name" class="form-control <?php if (session('errors.newName')) : ?>is-invalid<?php endif ?>" name="name" placeholder="<?= lang('Auth.newName') ?>" value="<?= $user->name ?>">
                    </div>

                    <div class="form-group">
                        <label for="surname"><?= lang('Auth.newSurname') ?></label>
                        <input type="text" id="surname" class="form-control <?php if (session('errors.newSurname')) : ?>is-invalid<?php endif ?>" name="surname" placeholder="<?= lang('Auth.newSurname') ?>" value="<?= $user->surname ?>">
                    </div>

                    <div class="form-group">
                        <label for="phone"><?= lang('Auth.newPhone') ?></label>
                        <input type="text" id="phone" class="form-control <?php if (session('errors.newPhone')) : ?>is-invalid<?php endif ?>" name="phone" placeholder="<?= lang('Auth.newPhone') ?>" value="<?= $user->phone ?>">
                    </div>

                    <div class="form-group">
                        <label for="city"><?= lang('Auth.newCity') ?></label>
                        <input type="text" id="city" class="form-control <?php if (session('errors.newCity')) : ?>is-invalid<?php endif ?>" name="city" placeholder="<?= lang('Auth.newCity') ?>" value="<?= $user->city ?>">
                    </div>

                    <div class="form-group">
                        <label for="street"><?= lang('Auth.newStreet') ?></label>
                        <input type="text" id="street" class="form-control <?php if (session('errors.newStreet')) : ?>is-invalid<?php endif ?>" name="street" placeholder="<?= lang('Auth.newStreet') ?>" value="<?= $user->street ?>">
                    </div>

                    <div class="form-group">
                        <label for="postal_code"><?= lang('Auth.newPostal_code') ?></label>
                        <input type="text" id="postal_code" class="form-control <?php if (session('errors.newPostal_code')) : ?>is-invalid<?php endif ?>" name="postal_code" placeholder="<?= lang('Auth.newPostal_code') ?>" value="<?= $user->postal_code ?>">
                    </div>

                    <div class="form-group">
                        <label for="userfile" class="form-label"> <?= lang('Auth.newImg') ?></label>
                        <input type="file" id="userfile" class="" <?php if (session('errors.newImg')) : ?>is-invalid<?php endif ?>" name="userfile" placeholder="<?= lang('Auth.newImg') ?>" value="<?= old('file') ?>">
                    </div>

                    <div id="messages"></div></br>
                    <input class="btn btn-primary" type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>


    <script>
        formUpdate.onsubmit = async (e) => {
            e.preventDefault();
            formRegistration = new FormData(formUpdate);
            var token = window.sessionStorage.getItem("tokenRefresh");

            if (token == "" || token == "undefined" || token == null) {
                var requestOptions = {
                    method: 'POST',
                    body: formRegistration,
                    headers: {
                        'Authorization': 'Bearer ' + <?php echo '"' . $_SESSION['token'] . '"' ?>,
                    }
                };
            } else {
                var requestOptions = {
                    method: 'POST',
                    body: formRegistration,
                    headers: {
                        'Authorization': 'Bearer ' + token,
                    }
                };
            }
            fetch("<?php echo base_url(); ?>/api/users/update", requestOptions)
                .then(response => response.json())
                .then((data) => {
                    if (data.status == 200) {
                        alert(data.messages);
                        window.sessionStorage.removeItem("tokenRefresh", data.refreshToken);
                        window.location = "<?php echo base_url(); ?>/logout";
                    } else {
                         if (data.status == 400) {
                            alert(data.messages);
                            window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
                        } else {
                            alert(data.messages);
                            var token = window.sessionStorage.removeItem("tokenRefresh");
                            window.location = "<?php echo base_url(); ?>/logout";
                        }
                        
                    }
                }).catch(error => {
                    alert("Unexpected error");
                    var token = window.sessionStorage.removeItem("tokenRefresh");
                    window.location = "<?php echo base_url(); ?>/logout";
                });
        }
    </script>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery-1.10.2.min.js') ?>"> </script>
    <script type="text/javascript" src="<?= base_url('js/bootstrap.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery-1.10.2.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/jquery.mixitup.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('js/main.js') ?>"></script>



</body>

</html>