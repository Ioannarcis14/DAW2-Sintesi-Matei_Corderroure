<!doctype html>
<html lang="en" class="restaurant">

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

<body class="restaurant">

    <?= view('App\layouts\_navbar') ?>

    <div role="main">

        <div class="imgContainer" style="margin: 50px; background-color: white">

            <?php
            if ($user->img_profile == null) {
                echo img(base_url('/img/dish.jpg'));
            } else {
                echo '<img src="/fileget/' . $user->img_profile . '" alt="image">';
            }
            ?>

        </div>

        <div class="dataContainer" style="margin: 50px; background-color: white">
            <?php
            echo '<div>Username: ' . $user->username . '</div>';
            echo '<div>Email: ' . $user->email . '</div>';
            echo '<div>Name: ' . $user->name . '</div>';
            echo '<div>Surname: ' . $user->surname . '</div>';
            echo '<div>Phone: ' . $user->phone . '</div>';
            echo '<div>City: ' . $user->city . '</div>';
            echo '<div>Street: ' . $user->street . '</div>';
            echo '<div>Postal Code: ' . $user->postal_code . '</div>';
            ?>
        </div>

        <div class="functionContainers">
            <div class="container" style="background-color: white">
                <h2>Change your data</h2>
                <form id="formUpdate">
                    <div class="form-group">
                        <label for="newEmail"><?= lang('Auth.newEmail') ?></label>
                        <input type="email" id="newEmail" class="form-control <?php if (session('errors.newEmail')) : ?>is-invalid<?php endif ?>" name="newEmail" aria-describedby="emailHelp" placeholder="<?= lang('Auth.newEmail') ?>" value="<?= $user->email ?>">
                    </div>

                    <div class="form-group">
                        <label for="newUsername"><?= lang('Auth.newUsername') ?></label>
                        <input type="text" id="newUsername" class="form-control <?php if (session('errors.newUsername')) : ?>is-invalid<?php endif ?>" name="newUsername" placeholder="<?= lang('Auth.newUsername') ?>" value="<?= $user->username ?>">
                    </div>

                    <div class="form-group">
                        <label for="newName"><?= lang('Auth.newName') ?></label>
                        <input type="text" id="newName" class="form-control <?php if (session('errors.newName')) : ?>is-invalid<?php endif ?>" name="newName" placeholder="<?= lang('Auth.newName') ?>" value="<?= $user->name ?>">
                    </div>

                    <div class="form-group">
                        <label for="newSurname"><?= lang('Auth.newSurname') ?></label>
                        <input type="text" id="newSurname" class="form-control <?php if (session('errors.newSurname')) : ?>is-invalid<?php endif ?>" name="newSurname" placeholder="<?= lang('Auth.newSurname') ?>" value="<?= $user->surname ?>">
                    </div>

                    <div class="form-group">
                        <label for="newPhone"><?= lang('Auth.newPhone') ?></label>
                        <input type="text" id="newPhone" class="form-control <?php if (session('errors.newPhone')) : ?>is-invalid<?php endif ?>" name="newPhone" placeholder="<?= lang('Auth.newPhone') ?>" value="<?= $user->phone ?>">
                    </div>

                    <div class="form-group">
                        <label for="newCity"><?= lang('Auth.newCity') ?></label>
                        <input type="text" id="newCity" class="form-control <?php if (session('errors.newCity')) : ?>is-invalid<?php endif ?>" name="city" placeholder="<?= lang('Auth.newCity') ?>" value="<?= $user->city ?>">
                    </div>

                    <div class="form-group">
                        <label for="newFile" class="form-label"> <?= lang('Auth.img') ?></label>
                        <input type="file" id="newFile" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" name="newFile" placeholder="<?= lang('Auth.file') ?>" value="<?= old('file') ?>">
                    </div>

                    <div class="form-group">
                        <label for="newStreet"><?= lang('Auth.newStreet') ?></label>
                        <input type="text" id="newStreet" class="form-control <?php if (session('errors.newStreet')) : ?>is-invalid<?php endif ?>" name="newStreet" placeholder="<?= lang('Auth.newStreet') ?>" value="<?= $user->street ?>">
                    </div>

                    <div class="form-group">
                        <label for="newPostal_code"><?= lang('Auth.newPostal_code') ?></label>
                        <input type="text" id="newPostal_code" class="form-control <?php if (session('errors.newPostal_code')) : ?>is-invalid<?php endif ?>" name="newPostal_code" placeholder="<?= lang('Auth.newPostal_code') ?>" value="<?= $user->postal_code ?>">
                    </div>

                    <div id="messages"></div></br>
                    <input class="btn btn-primary" type="submit" value="Update">
                </form>
            </div>
        </div>
    </div>


    <script>
        function getCookie(cname) {
            let name = cname + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        formUpdate.onsubmit = async (e) => {
            e.preventDefault();
            formRegistration = new FormData(formUpdate);
            var token = getCookie("tokenRefresh");

            if (token == "") {
                var requestOptions = {
                    method: 'POST',
                    body: formRegistration,
                    Authorization: 'Bearer ' + <?= json_encode($_SESSION['token']);?>,
                };
            } else {
                var requestOptions = {
                    method: 'POST',
                    body: formRegistration,
                    Authorization: 'Bearer ' + token,
                };
            }

            fetch("<?php echo base_url(); ?>/api/users/update", requestOptions)
                .then(response => response.text())
                .then((data) => {
                    if (data.status == 200) {
                        document.getElementById("messages").innerHTML = "";
                        document.getElementById("messages").innerHTML = "Message: " + data.messages;
                    } else {
                        document.getElementById("messages").innerHTML = "";
                        document.getElementById("messages").innerHTML = "Error: " + data.messages;
                    }
                }).catch(error => {
                    document.getElementById("messages").innerHTML = "Error: There\'s been an error with the update process";
                });

        }
    </script>




    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php base_url('js/jquery-1.10.2.min.js')?>"> </script>
    <script type="text/javascript" src="<?php base_url('js/bootstrap.min.js')?>'"></script>
    <script type="text/javascript" src="<?php base_url('js/jquery-1.10.2.js')?>"></script>
    <script type="text/javascript" src="<?php base_url('js/jquery.mixitup.min.js')?>"></script>
    <script type="text/javascript" src="<?php base_url('js/main.js')?>"></script>

</body>

</html>