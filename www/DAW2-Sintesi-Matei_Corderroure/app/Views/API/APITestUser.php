<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Calls</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <style>
        #token {
            word-wrap: break-word;
        }
        .container {
            padding: 10px;
        }
    </style>
</head>

<!-- NAV BAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Pick Eat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= base_url('/api/testAuth'); ?>">Auth Calls</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/api/testUser'); ?>">User Calls<span class="sr-only">(current)</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Responsable Calls
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Manage Staff</a></li>
                    <li><a class="dropdown-item" href="#">Manage Restaurants</a></li>
                    <li><a class="dropdown-item" href="#">Manage Dishes</a></li>
                    <li><a class="dropdown-item" href="#">Manage Categories</a></li>
                    <li><a class="dropdown-item" href="#">Manage Supplements</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/api/testAdmin'); ?>">Admin Calls</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Admin Calls
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Manage Users</a></li>
                    <li><a class="dropdown-item" href="#">Manage Roles</a></li>
                    <li><a class="dropdown-item" href="#">Discharge Restaurants</a></li>
                    <li><a class="dropdown-item" href="#">Manage Themes</a></li>
                    <li><a class="dropdown-item" href="#">Manage messages</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/api/testResponsable'); ?>">Responsable Calls</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/api/testStaff'); ?>">Staff Calls</a>
            </li>
        </ul>
    </div>
</nav>


<body>
    <div class="container">
        <h1>API Test - User Calls</h1>
            <div class="container">
                <h2>Change your data</h2>
                <form id="formUpdate">
                    <div class="form-group">
                        <label for="newEmail"><?= lang('Auth.newEmail') ?></label>
                        <input type="email" id="newEmail" class="form-control <?php if (session('errors.newEmail')) : ?>is-invalid<?php endif ?>" name="newEmail" aria-describedby="emailHelp" placeholder="<?= lang('Auth.newEmail') ?>" value="<?= old('newEmail') ?>">
                    </div>

                    <div class="form-group">
                        <label for="newUsername"><?= lang('Auth.newUsername') ?></label>
                        <input type="text" id="newUsername" class="form-control <?php if (session('errors.newUsername')) : ?>is-invalid<?php endif ?>" name="newUsername" placeholder="<?= lang('Auth.newUsername') ?>" value="<?= old('newUsername') ?>">
                    </div>

                    <div class="form-group">
                        <label for="newName"><?= lang('Auth.newName') ?></label>
                        <input type="text" id="newName" class="form-control <?php if (session('errors.newName')) : ?>is-invalid<?php endif ?>" name="newName" placeholder="<?= lang('Auth.newName') ?>" value="<?= old('newName') ?>">
                    </div>

                    <div class="form-group">
                        <label for="newSurname"><?= lang('Auth.newSurname') ?></label>
                        <input type="text" id="newSurname" class="form-control <?php if (session('errors.newSurname')) : ?>is-invalid<?php endif ?>" name="newSurname" placeholder="<?= lang('Auth.newSurname') ?>" value="<?= old('newSurname') ?>">
                    </div>

                    <div class="form-group">
                        <label for="newPhone"><?= lang('Auth.newPhone') ?></label>
                        <input type="text" id="newPhone" class="form-control <?php if (session('errors.newPhone')) : ?>is-invalid<?php endif ?>" name="newPhone" placeholder="<?= lang('Auth.newPhone') ?>" value="<?= old('newPhone') ?>">
                    </div>

                    <div class="form-group">
                        <label for="newCity"><?= lang('Auth.newCity') ?></label>
                        <input type="text" id="newCity" class="form-control <?php if (session('errors.newCity')) : ?>is-invalid<?php endif ?>" name="city" placeholder="<?= lang('Auth.newCity') ?>" value="<?= old('newCity') ?>">
                    </div>

                    <div class="form-group">
                        <label for="newStreet"><?= lang('Auth.newStreet') ?></label>
                        <input type="text" id="newStreet" class="form-control <?php if (session('errors.newStreet')) : ?>is-invalid<?php endif ?>" name="newStreet" placeholder="<?= lang('Auth.newStreet') ?>" value="<?= old('newStreet') ?>">
                    </div>

                    <div class="form-group">
                        <label for="newPostal_code"><?= lang('Auth.newPostal_code') ?></label>
                        <input type="text" id="newPostal_code" class="form-control <?php if (session('errors.newPostal_code')) : ?>is-invalid<?php endif ?>" name="newPostal_code" placeholder="<?= lang('Auth.newPostal_code') ?>" value="<?= old('newPostal_code') ?>">
                    </div>

                    <div id="message"></div></br>
                    <input class="btn btn-primary" type="submit" value="Change your data">
                </form>
            </div>

        <div class="container">
            <h2>Change your profile picture</h2>
            <div class="form-group">
                <label for="file"><?= lang('Auth.img') ?></label>
                <input type="file" id="userfile" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" name="userfile" placeholder="<?= lang('Auth.file') ?>" value="<?= old('file') ?>">
            </div>
            <div id="token"></div>
            <div id="errors"></div> </br>
            <button class="btn btn-primary" onclick="changeImg()">Change</button>
            </input>
        </div>
        <div class="container">
            <h2>Change your password</h2>
            <div class="form-group">
                <label for="newPassword"><?= lang('Auth.newPassword') ?></label>
                <input type="password" id="newPassword" name="newPassword" class="form-control <?php if (session('errors.newPassword')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.newPassword') ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="newPasswordRepeat"><?= lang('Auth.newPasswordRepeat') ?></label>
                <input type="password" id="newPasswordRepeat" name="newPasswordRepeat" class="form-control <?php if (session('errors.newPasswordRepeat')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.newPasswordRepeat') ?>" autocomplete="off">
            </div>
            <div id="token"></div>
            <div id="errors"></div> </br>
            <button class="btn btn-primary" onclick="changePassword()">Change</button>
            </input>
        </div>
        <div class="container">
            <h2>Contact the restaurant</h2>
            <div class="form-group">
                <label for="login">Email address</label>
                <input type="text" class="form-control" id="login" aria-describedby="emailHelp" placeholder="Enter email or username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
            </div>
            <div id="token"></div>
            <div id="errors"></div> </br>
            <button class="btn btn-primary" onclick="contact()">Contact</button>
            </input>
        </div>
        <div class="container">
            <h2>Contact the admins</h2>
            <div class="form-group">
                <label for="login">Email address</label>
                <input type="text" class="form-control" id="login" aria-describedby="emailHelp" placeholder="Enter email or username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
            </div>
            <div id="token"></div>
            <div id="errors"></div> </br>
            <button class="btn btn-primary" onclick="contact()">Contact</button>
            </input>
        </div>
        <div class="container">
            <h2>Valorate the restaurant</h2>
            <div class="form-group">
                <label for="login">Email address</label>
                <input type="text" class="form-control" id="login" aria-describedby="emailHelp" placeholder="Enter email or username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
            </div>
            <div id="token"></div>
            <div id="errors"></div> </br>
            <button class="btn btn-primary" onclick="review()">Review</button>
            </input>
        </div>
        <div class="container">
            <h2>Make ur order</h2>
            <div class="form-group">
                <label for="login">Email address</label>
                <input type="text" class="form-control" id="login" aria-describedby="emailHelp" placeholder="Enter email or username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
            </div>
            <div id="token"></div>
            <div id="errors"></div> </br>
            <button class="btn btn-primary" onclick="order()">Make an order</button>
            </input>
        </div>
    </div>

</body>
<script>
    

    async function logout() {

    }
</script>

</html>