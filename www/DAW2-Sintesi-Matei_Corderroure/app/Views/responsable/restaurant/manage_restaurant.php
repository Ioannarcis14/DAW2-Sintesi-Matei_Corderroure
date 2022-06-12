<?= view('App\layouts\layout_restaurant') ?>

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

    <h3 style="text-align: center;margin-bottom: 20px;"><?= esc($title); ?></h3>

    <table class="table table-hover" style='border-collapse: collapse;'>
        <thead>
            <tr>
                <th>Functions</th>
            </tr>
        </thead>
        <tbody>
                <td>
                <a class='btn btn-info' role='button' href='"<?php echo base_url("responsable/restaurant/".$r."/"."staff/manage/")?>"'>
                Manage Staff</a>
                <a class='btn btn-info' role='button' href='"<?php echo base_url("responsable/restaurant/".$r."/"."categories/manage/")?>"'>
                Manage Categories</a>
                <a class='btn btn-info' role='button' href='"<?php echo base_url("responsable/restaurant/".$r."/"."dishes/manage/")?>"'>
                Manage Dishes</a>
                <a class='btn btn-info' role='button' href='"<?php echo base_url("responsable/restaurant/".$r."/"."supplements/manage/")?>"'>
                Manage Supplements</a>
                <a class='btn btn-info' role='button' href='"<?php echo base_url("responsable/restaurant/".$r."/"."valorations/see/")?>"'>
                See valorations</a>
                </td>
        </tbody>
    </table>

</div>

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