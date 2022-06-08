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
        <h2>Remove roles</h2></br>
        <div id="createUser">
        <div class="form-group">
                    <label for="roles"><?= lang('Auth.roles') ?></label>
                    <select id="roles" class="form-control <?php if (session('errors.roles')) : ?>is-invalid<?php endif ?>" name="roles" aria-describedby="emailHelp" placeholder="<?= lang('Auth.roles') ?>">
                        <?php
                        foreach ($roles as $role) {
                            echo '<option value="' . $role->id . '">' . $role->name . '</option>';
                        }
                        ?>
                    </select>
                </div>

            <div class="form-group">
                <label for="username"><?= lang('Auth.username') ?></label>
                <input type="text" id="username" disabled="disabled" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= $user->name ?>" value="<?= $user->name ?>">
            </div>

            <div id="message"></div></br>
            <button class="btn btn-danger" type="submit" value="Assign" onclick="removeRole()">Remove
    </div>

</body>

</html>

<script>
    async function removeRole() {
        var id_role = document.getElementById("roles").value;
        var id_user = document.getElementById("username").value;
        var token = window.sessionStorage.getItem("tokenRefresh");
        var response;

        if (token == "" || token == "undefined" || token == null) {
            response = await fetch("<?php echo base_url(); ?>/api/users/removeRole", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + <?php echo '"' . $_SESSION['token'] . '"' ?>,
                },
                body: JSON.stringify({
                    id_role: id_role,
                    id_user: <?php echo $user->id ?>,
                }),
            });
        } else {
            response = await fetch("<?php echo base_url(); ?>/api/users/removeRole", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify({
                    id_role: id_role,
                    id_user: <?php echo $user->id ?>,
                }),
            });
        }

        response.json().then((data) => {
            if (data.error == false) {
                alert(data.messages);
                window.sessionStorage.setItem("tokenRefresh", data.refreshToken);
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


</body>

</html>

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