<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?=base_url('/admin/users');?>">User Administration</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('/admin/roles');?>">Assign Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('/samplekpcrud2');?>">Manage Roles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('/samplekpcrud/1n');?>">See messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('/samplekpcrud/multikey');?>">Discharge Restaurants</a>
                </li>
            </ul>
        </div>
    </nav>    
    
    <div class="container-lg">
        <?= $output ?>
    </div>
</body>

</html>