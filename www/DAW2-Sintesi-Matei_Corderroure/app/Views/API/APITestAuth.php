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
                <a class="nav-link" href="<?= base_url('/api/testAuth'); ?>">Auth Calls<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/api/testUser'); ?>">User Calls</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/api/testAdmin'); ?>">Admin Calls</a>
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
        <h1>API Test - Auth Calls</h1>
        <div class="container">
            <h2>Register</h2></br>
            <div class="form-group">
                <label for="email"><?= lang('Auth.email') ?></label>
                <input type="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
            </div>

            <div class="form-group">
                <label for="username"><?= lang('Auth.username') ?></label>
                <input type="text" class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
            </div>

            <div class="form-group">
                <label for="name"><?= lang('Auth.name') ?></label>
                <input type="text" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" name="name" placeholder="<?= lang('Auth.name') ?>" value="<?= old('name') ?>">
            </div>

            <div class="form-group">
                <label for="surname"><?= lang('Auth.surname') ?></label>
                <input type="text" class="form-control <?php if (session('errors.surname')) : ?>is-invalid<?php endif ?>" name="surname" placeholder="<?= lang('Auth.surname') ?>" value="<?= old('surname') ?>">
            </div>

            <div class="form-group">
                <label for="phone"><?= lang('Auth.phone') ?></label>
                <input type="text" class="form-control <?php if (session('errors.phone')) : ?>is-invalid<?php endif ?>" name="phone" placeholder="<?= lang('Auth.phone') ?>" value="<?= old('phone') ?>">
            </div>

            <div class="form-group">
                <label for="city"><?= lang('Auth.city') ?></label>
                <input type="text" class="form-control <?php if (session('errors.city')) : ?>is-invalid<?php endif ?>" name="city" placeholder="<?= lang('Auth.city') ?>" value="<?= old('city') ?>">
            </div>

            <div class="form-group">
                <label for="street"><?= lang('Auth.street') ?></label>
                <input type="text" class="form-control <?php if (session('errors.street')) : ?>is-invalid<?php endif ?>" name="street" placeholder="<?= lang('Auth.street') ?>" value="<?= old('street') ?>">
            </div>

            <div class="form-group">
                <label for="postal_code"><?= lang('Auth.postal_code') ?></label>
                <input type="text" class="form-control <?php if (session('errors.postal_code')) : ?>is-invalid<?php endif ?>" name="postal_code" placeholder="<?= lang('Auth.postal_code') ?>" value="<?= old('postal_code') ?>">
            </div>

            <div class="form-group">
                <label for="file"><?= lang('Auth.img') ?></label>
                <input type="file" class="form-control <?php if (session('errors.name')) : ?>is-invalid<?php endif ?>" name="file" placeholder="<?= lang('Auth.file') ?>" value="<?= old('file') ?>">
            </div>

            <div class="form-group">
                <label for="password"><?= lang('Auth.password') ?></label>
                <input type="password" name="password" class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
            </div>

            <div class="form-group">
                <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
                <input type="password" name="pass_confirm" class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
            </div>

            <div id="token"></div>
            <div id="errors"></div></br>

            <button class="btn btn-primary" onclick="register()">Register</button>
            </input>
        </div>

        <div class="container">
            <h2>Login</h2></br>
            <div class="form-group">
                <label for="login">Email address</label>
                <input type="text" class="form-control" id="login" aria-describedby="emailHelp" placeholder="Enter email or username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
            </div>
            <div id="token"></div>
            <div id="errors"></div></br>
            <button class="btn btn-primary" onclick="login()">Login</button>
            </input>
        </div>
        <div class="container">
            <h2>Logout</h2></br>
            <div class="form-group">
                <label for="token">Token</label>
                <input type="text" class="form-control" id="token" placeholder="Authentication Token">
            </div>
            <div id="messages"></div>
            <div id="errors"></div></br>
            <button class="btn btn-danger" onclick=hola()>Logout</button>
        </div>
</body>
<script>
    async function login() {
        let response = await fetch("http://localhost:80/api/login", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                login: document.getElementById('login').value,
                password: document.getElementById('password').value,
            }),
        });
        response.json().then((data) => {
            if (data.status = 200) {
                console.log(data.token);
                document.getElementById("token").innerHTML = "Token: " + data.token;
            } else {
                document.getElementById("errors").innerHTML = "Errors: " + data.messages;
            }
        });
    }

    async function register() {
        let response = await fetch("http://localhost:80/api/register", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                login: document.getElementById('login').value,
                password: document.getElementById('password').value,
            }),
        });
        response.json().then((data) => {
            if (data.status = 200) {
                console.log(data.token);
                document.getElementById("token").innerHTML = "Token: " + data.token;
            } else {
                document.getElementById("errors").innerHTML = "Errors: " + data.messages;
            }
        });
    }

    async function logout() {

    }
</script>

</html>