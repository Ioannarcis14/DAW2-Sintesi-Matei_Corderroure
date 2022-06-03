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
            <a class="btn btn-primary" href="/user/changeData">Change your data</a>
        </div>

        <div style="margin: 50px; background-color: white">
            <h2 style="padding-bottom: 50px">Change your password</h2>
            <div class="form-group">
                <label for="newPassword"><?= lang('Auth.newPassword') ?></label>
                <input type="password" id="newPassword" name="newPassword" class="form-control <?php if (session('errors.newPassword')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.newPassword') ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="newPasswordRepeat"><?= lang('Auth.newPasswordRepeat') ?></label>
                <input type="password" id="newPasswordRepeat" name="newPasswordRepeat" class="form-control <?php if (session('errors.newPasswordRepeat')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.newPasswordRepeat') ?>" autocomplete="off">
            </div></br>
            <button class="btn btn-primary" onclick="changePassword()">Change</button>
            </input>
        </div>





    </div>

    <script>
        async function changePassword() {

            var newPass = document.getElementById("newPassword").value;
            var newPassConfirm = document.getElementById("newPasswordRepeat").value;
            var token = window.sessionStorage.getItem("tokenRefresh");
            var email = <?= json_encode($user->email) ?>;
            var response;

            if (token == "" || token == "undefined" || token == null) {
                response = await fetch("<?php echo base_url(); ?>/api/users/changePass", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + <?php echo '"'.$_SESSION['token'].'"'?>,
                },
                body: JSON.stringify({
                    newPass: newPass,
                    newPassConfirm: newPassConfirm,
                    email: email
                }),
            });
            } else {
                response = await fetch("<?php echo base_url(); ?>/api/users/changePass", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify({
                    newPass: newPass,
                    newPassConfirm: newPassConfirm,
                    email: email
                }),
            });
            }

            response.json().then((data) => {
                if (data.error == false) {
                    alert(data.messages);
                    window.sessionStorage.setItem("tokenRefresh",data.refreshToken);
                } else {
                    if(data.status == 400) {
                        alert(data.messages);
                        window.sessionStorage.setItem("tokenRefresh",data.refreshToken);
                    } else {
                        alert(data.messages);
                        var token = window.sessionStorage.removeItem("tokenRefresh");
                        window.location = "<?php echo base_url(); ?>/logout";
                    }

                }
            }).catch(error => {
                alert(error.messages);
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
    <script type="text/javascript" src="<?php base_url('js/jquery-1.10.2.min.js')?>"> </script>
    <script type="text/javascript" src="<?php base_url('js/bootstrap.min.js')?>"></script>
    <script type="text/javascript" src="<?php base_url('js/jquery-1.10.2.js')?>"></script>
    <script type="text/javascript" src="<?php base_url('js/jquery.mixitup.min.js')?>"></script>
    <script type="text/javascript" src="<?php base_url('js/main.js')?>"></script>

</body>

</html>