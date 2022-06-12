<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management</title>
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= base_url('/'); ?>">Pick Eat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/admin/users'); ?>">Manage Staff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/admin/roles'); ?>">Manage Menus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/admin/themes'); ?>">Manage Dishes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/admin/discharge'); ?>">Manage Supplements</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/admin/messages'); ?>">See valorations</a>
            </li>
        </ul>
    </div>
</nav>