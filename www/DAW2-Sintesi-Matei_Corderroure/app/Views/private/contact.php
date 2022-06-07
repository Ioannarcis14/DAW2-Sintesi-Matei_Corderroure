<!doctype html>
<html lang="en" class="contact">

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

<body class="contact">

    <?= view('App\layouts\_navbar') ?>

    <div role="main" class="p_main">
        <div class="container" style="padding: 50px; background-color: white">
            <h2 style="padding-bottom: 50px">Contact us</h2>
                <div class="form-group">
                    <label for="theme"><?= lang('Auth.theme') ?></label>
                    <select id="theme" class="form-control <?php if (session('errors.theme')) : ?>is-invalid<?php endif ?>" name="theme" aria-describedby="emailHelp" placeholder="<?= lang('Auth.theme') ?>">
                        <?php
                        foreach ($themes as $theme) {
                            echo '<option value="' . $theme['name'] . '">' . $theme['name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="commentary"><?= lang('Auth.commentary') ?></label>
                    <textarea type="text" id="commentary" class="form-control <?php if (session('errors.textarea')) : ?>is-invalid<?php endif ?>" name="textarea" placeholder="<?= lang('Auth.textarea') ?>">
                    </textarea>
                </div>
                </br>
                <button class="btn btn-primary" onclick="contact()">Send</button>
        </div>
    </div>

</body>

</html>
<script>
    async function contact() {

        var commentary = document.getElementById("commentary").value;
        var theme = document.getElementById("theme").value;
        var response;
        var token = window.sessionStorage.getItem("tokenRefresh");

        if (token == "" || token == "undefined" || token == null) {
            response = await fetch("<?php echo base_url(); ?>/api/users/contact", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + <?php echo '"' . $_SESSION['token'] . '"' ?>,
                },
                body: JSON.stringify({
                    commentary: commentary,
                    theme: theme,
                }),
            });
        } else {
            response = await fetch("<?php echo base_url(); ?>/api/users/contact", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify({
                    commentary: commentary,
                    theme: theme,
                }),
            });
        }

        response.json().then((data) => {
            if (data.error == false) {
                alert(data.messages);
                window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
                window.location = "<?php echo base_url(); ?>/home";
            } else {
                if (data.status == 400) {
                    alert(data.messages);
                    window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
                    window.location = "<?php echo base_url(); ?>/home";
                } else {
                    alert(data.messages);
                    window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
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
<script type="text/javascript" src="<?= base_url('js/jquery-1.10.2.min.js') ?>"> </script>
<script type="text/javascript" src="<?= base_url('js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/jquery-1.10.2.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/jquery.mixitup.min.js') ?>"></script>
<script type="text/javascript" src="<?= base_url('js/main.js') ?>"></script>



</body>

</html>