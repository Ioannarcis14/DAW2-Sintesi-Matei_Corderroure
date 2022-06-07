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
        <div class="container" style="margin: 200px; background-color: white">
            <h2>Dicharge your own restaurant</h2>
            <form id="discharge">
                <div class="form-group">
                    <label for="nameRestaurant"><?= lang('Auth.nameRestaurant') ?></label>
                    <input type="text" id="nameRestaurant" class="form-control <?php if (session('errors.nameRestaurant')) : ?>is-invalid<?php endif ?>" name="nameRestaurant" aria-describedby="emailHelp" placeholder="<?= lang('Auth.nameRestaurant') ?>" value="">
                </div>

                <div class="form-group">
                    <label for="cityRestaurant"><?= lang('Auth.cityRestaurant') ?></label>
                    <input type="text" id="cityRestaurant" class="form-control <?php if (session('errors.cityRestaurant')) : ?>is-invalid<?php endif ?>" name="cityRestaurant" placeholder="<?= lang('Auth.cityRestaurant') ?>" value="">
                </div>

                <div class="form-group">
                    <label for="streetRestaurant"><?= lang('Auth.streetRestaurant') ?></label>
                    <input type="text" id="name" class="form-control <?php if (session('errors.streetRestaurant')) : ?>is-invalid<?php endif ?>" name="streetRestaurant" placeholder="<?= lang('Auth.streetRestaurant') ?>" value="">
                </div>

                <div class="form-group">
                    <label for="phoneRestaurant"><?= lang('Auth.phoneRestaurant') ?></label>
                    <input type="text" id="phoneRestaurant" class="form-control <?php if (session('errors.phoneRestaurant')) : ?>is-invalid<?php endif ?>" name="phoneRestaurant" placeholder="<?= lang('Auth.phoneRestaurant') ?>" value="">
                </div>

                <div class="form-group">
                    <label for="postal_codeRestaurant"><?= lang('Auth.postal_codeRestaurant') ?></label>
                    <input type="text" id="postal_codeRestaurant" class="form-control <?php if (session('errors.postal_codeRestaurant')) : ?>is-invalid<?php endif ?>" name="postal_codeRestaurant" placeholder="<?= lang('Auth.postal_codeRestaurant') ?>" value="">
                </div>

                <div class="form-group">
                    <label for="twitterRestaurant"><?= lang('Auth.twitterRestaurant') ?></label>
                    <input type="text" id="twitterRestaurant" class="form-control <?php if (session('errors.twitterRestaurant')) : ?>is-invalid<?php endif ?>" name="twitterRestaurant" placeholder="<?= lang('Auth.twitterRestaurant') ?>" value="">
                </div>

                <div class="form-group">
                    <label for="facebookRestaurant"><?= lang('Auth.facebookRestaurant') ?></label>
                    <input type="text" id="facebookRestaurant" class="form-control <?php if (session('errors.facebookRestaurant')) : ?>is-invalid<?php endif ?>" name="facebookRestaurant" placeholder="<?= lang('Auth.facebookRestaurant') ?>" value="">
                </div>

                <div class="form-group">
                    <label for="instagramRestaurant"><?= lang('Auth.facebookRestaurant') ?></label>
                    <input type="text" id="instagramRestaurant" class="form-control <?php if (session('errors.instagramRestaurant')) : ?>is-invalid<?php endif ?>" name="instagramRestaurant" placeholder="<?= lang('Auth.instagramRestaurant') ?>" value="">
                </div>

                <div class="form-group">
                    <label for="userfile[]" class="form-label"> <?= lang('Auth.newImgRestaurant') ?></label>
                    <input type="file" id="userfile[]" class="form-control <?php if (session('errors.newImgRestaurant')) : ?>is-invalid<?php endif ?>" name="userfile[]" multiple placeholder="<?= lang('Auth.newImgRestaurant') ?>" value="">
                </div>

                <div id="messages"></div></br>
                <input class="btn btn-primary" type="submit" value="Update">
            </form>
        </div>
    </div>

</body>

</html>
<script>
    discharge.onsubmit = async (e) => {
        e.preventDefault();
        formRegistration = new FormData(discharge);
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

        fetch("<?php echo base_url(); ?>/api/users/discharge", requestOptions)
            .then(response => response.json())
            .then((data) => {
                if (data.status == false) {
                    alert(data);
                    console.log(data)
                    window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
                    window.location = "<?php echo base_url(); ?>/home";
                } else {
                    if (data.status == 400) {
                        alert(data);
                        window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
                    } else {
                        alert(data);
                        window.sessionStorage.removeItem("tokenRefresh");
                        window.location = "<?php echo base_url(); ?>/logout";
                    }

                }
            }).catch(error => {
                alert("There's been an error with the update");
                window.sessionStorage.removeItem("tokenRefresh");
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