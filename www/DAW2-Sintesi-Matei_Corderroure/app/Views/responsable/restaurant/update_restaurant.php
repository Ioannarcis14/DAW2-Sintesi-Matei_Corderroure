<?= view('App\layouts\layout_responsable') ?>

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
    <div class="container" style="background-color: white">
        <h2 style="padding-bottom: 50px">Update this restaurant</h2>
        <form id="update">

            <div class="form-group">
                <label for="descriptionRestaurant"><?= lang('Auth.newDescriptionRestaurant') ?></label>
                <textarea name="descriptionRestaurant" class="form-control" id="descriptionRestaurant" cols="45" rows="4"><?php echo $restaurant['description'] ?></textarea></br>
            </div>

            <div class="form-group">
                <label for="name"><?= lang('Auth.newNameRestaurant') ?></label>
                <input type="text" id="name" class="form-control <?php if (session('errors.nameRestaurant')) : ?>is-invalid<?php endif ?>" name="name" placeholder="<?= lang('Auth.nameRestaurant') ?>" value="<?php echo $restaurant['name'] ?>">
            </div>

            <div class="form-group">
                <label for="city"><?= lang('Auth.newCityRestaurant') ?></label>
                <input type="text" id="city" class="form-control <?php if (session('errors.cityRestaurant')) : ?>is-invalid<?php endif ?>" name="city" placeholder="<?= lang('Auth.cityRestaurant') ?>" value="<?php echo $restaurant['city'] ?>">
            </div>

            <div class="form-group">
                <label for="street"><?= lang('Auth.newStreetRestaurant') ?></label>
                <input type="text" id="street" class="form-control <?php if (session('errors.streetRestaurant')) : ?>is-invalid<?php endif ?>" name="street" placeholder="<?= lang('Auth.streetRestaurant') ?>" value="<?php echo $restaurant['street'] ?>">
            </div>

            <div class="form-group">
                <label for="postal_code"><?= lang('Auth.newPostal_codeRestaurant') ?></label>
                <input type="text" id="postal_code" class="form-control <?php if (session('errors.postal_codeRestaurant')) : ?>is-invalid<?php endif ?>" name="postal_code" placeholder="<?= lang('Auth.postal_codeRestaurant') ?>" value="<?php echo $restaurant['postal_code'] ?>">
            </div>

            <div class="form-group">
                <label for="phone"><?= lang('Auth.newPhoneRestaurant') ?></label>
                <input type="text" id="phone" class="form-control <?php if (session('errors.phoneRestaurant')) : ?>is-invalid<?php endif ?>" name="phone" placeholder="<?= lang('Auth.phoneRestaurant') ?>" value="<?php echo $restaurant['phone'] ?>">
            </div>

            <div class="form-group">
                <label for="twitter"><?= lang('Auth.newTwitterRestaurant') ?></label>
                <input type="text" id="twitter" class="form-control <?php if (session('errors.twitterRestaurant')) : ?>is-invalid<?php endif ?>" name="twitter" placeholder="<?= lang('Auth.twitterRestaurant') ?>" value="<?php echo $restaurant['twitter'] ?>">
            </div>

            <div class="form-group">
                <label for="facebook"><?= lang('Auth.newFacebookRestaurant') ?></label>
                <input type="text" id="facebook" class="form-control <?php if (session('errors.facebookRestaurant')) : ?>is-invalid<?php endif ?>" name="facebook" placeholder="<?= lang('Auth.facebookRestaurant') ?>" value="<?php echo $restaurant['facebook'] ?>">
            </div>

            <div class="form-group">
                <label for="instagram"><?= lang('Auth.newInstagramRestaurant') ?></label>
                <input type="text" id="instagram" class="form-control <?php if (session('errors.instagramRestaurant')) : ?>is-invalid<?php endif ?>" name="instagram" placeholder="<?= lang('Auth.instagramRestaurant') ?>" value="<?php echo $restaurant['instagram'] ?>">
            </div>

            <div class="form-group">
                <label for="userfile[]" class="form-label"> <?= lang('Auth.newImgRestaurant') ?></label>
                <input type="file" id="userfile[]" class=" <?php if (session('errors.newImgRestaurant')) : ?>is-invalid<?php endif ?>" name="userfile[]" multiple placeholder="<?= lang('Auth.newImgRestaurant') ?>" value="">
            </div>
            <input class="btn btn-primary" type="submit" value="Update">
        </form>
    </div>

</body>

</html>

<script>
    update.onsubmit = async (e) => {
        e.preventDefault();
        formRegistration = new FormData(update);
        var token = window.sessionStorage.getItem("tokenRefresh");
        console.log(document.getElementById("descriptionRestaurant").value);
        update.append("description", document.getElementById("descriptionRestaurant").value);
        
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

        fetch("<?php echo base_url(); ?>/api/restaurant/update/" + <?php echo $restaurant['id'] ?>, requestOptions)
            .then(response => response.json())
            .then((data) => {
                if (data.status == 200) {
                    alert(data.messages);
                    window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
                } else {
                    if (data.status == 400) {
                        alert(data.messages);
                        window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
                    } else {
                        alert(data.messages);
                        var token = window.sessionStorage.removeItem("tokenRefresh");
                      //  window.location = "<?php echo base_url(); ?>/logout";
                    }

                }
            }).catch(error => {
                alert("Unexpected error");
                var token = window.sessionStorage.removeItem("tokenRefresh");
           //     window.location = "<?php echo base_url(); ?>/logout";
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