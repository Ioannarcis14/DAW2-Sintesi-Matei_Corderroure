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
                <a class="nav-link" href="<?= base_url('/api/testAuth'); ?>">Auth Calls</span></a>
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
                <a class="nav-link" href="<?= base_url('/api/testStaff'); ?>">Staff Calls <span class="sr-only">(current)</a>
            </li>
        </ul>
    </div>
</nav>

<body>
    <div class="container">
        <h1>API Test - Staff Calls</h1>
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
                <div id="errors"></div>
                <button class="btn btn-primary" onclick="login()">Login</button>
            </input>
        </div>
        <div class="container">
            <h2>Register</h2></br>
                <div class="form-group">
                    <label for="asdf">Email address</label>
                    <input type="text" class="form-control" id="asdf" aria-describedby="emailHelp" placeholder="Enter email or username">
                </div>
                <div class="form-group">
                    <label for="asdfddd">Password</label>
                    <input type="password" class="form-control" id="asdfddd" placeholder="Enter your password">
                </div>
                <?php
                ?>
                <button class="btn btn-primary" onclick=hola()>Register</button>
            </input>
        </div>
        <div class="container">
            <h2>Logout</h2></br>
                <button class="btn btn-danger" onclick=hola()>Logout</button>
            </input>
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
                document.getElementById("token").innerHTML = "Token: "+ data.token;
            } else {
                document.getElementById("errors").innerHTML = "Errors: "+ data.messages;
            }
        });
        
        /*
        idk.then((data) => {
            console.log(data.token);
        });
        /*
        var formData = new FormData();
        
        formData.append("login", document.getElementById('login').value);
        formData.append("password", document.getElementById('password').value);
        
        var request = new XMLHttpRequest();
        request.open("POST", "http://localhost:80/api/login");
        request.send(formData);
        
        fetch(request)
        .then((request) => request.json())
        .then((data) => {
            console.log('Response from server');    
            console.log()
        })
        */
        
    }

    async function register() {
        
    }

    async function logout() {
        
    }
</script>

</html>