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

        <div style="margin: 50px; background-color: white">
            <h2>Change your password</h2>
            <div class="form-group">
                <label for="newPassword"><?= lang('Auth.newPassword') ?></label>
                <input type="password" id="newPassword" name="newPassword" class="form-control <?php if (session('errors.newPassword')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.newPassword') ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="newPasswordRepeat"><?= lang('Auth.newPasswordRepeat') ?></label>
                <input type="password" id="newPasswordRepeat" name="newPasswordRepeat" class="form-control <?php if (session('errors.newPasswordRepeat')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.newPasswordRepeat') ?>" autocomplete="off">
            </div>
            <div id="messages"></div> </br>
            <button class="btn btn-primary" onclick="changePassword()">Change</button>
            </input>
        </div>

        <div class="functionContainers">
            <a class="btn btn-primary" href="/user/changeData">Change your data</a>
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
                    document.getElementById("messages").innerHTML = data.messages;
                    window.sessionStorage.setItem("tokenRefresh",data.refreshToken);
                } else {
                    if(data.status != 401) {
                        document.getElementById("messages").innerHTML = data.messages;
                        window.sessionStorage.setItem("tokenRefresh",data.refreshToken);
                    } else {
                        var token = window.sessionStorage.removeItem("tokenRefresh");
                        window.location = "<?php echo base_url(); ?>/logout";
                    }

                }
            }).catch(error => {
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
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"> </script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="js/jquery.mixitup.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>

</body>

</html>