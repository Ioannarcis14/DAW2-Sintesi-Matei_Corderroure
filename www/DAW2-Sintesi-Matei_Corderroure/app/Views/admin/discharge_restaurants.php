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

    <h3 style="text-align: center;margin-bottom: 20px;"><?= esc($title); ?></h3>
    <!-- Search form -->
    <form method='get' action="<?= base_url('admin/discharge'); ?>" id="searchForm">
        <input type='text' name='q' value='<?= $search ?>' placeholder="Search here...">
        <input type='button' id='btnsearch' value='Cercar' onclick='document.getElementById("searchForm").submit();'>
    </form>
    <br />

    <table class="table table-hover" style='border-collapse: collapse;'>
        <thead>
            <tr>
                <th><a href="<?=base_url('admin/discharge')?>?order=id&q=<?=$search?>&page=<?=$activepage?>&active=<?=$act?>">ID</a></th>
                <th><a href="<?=base_url('admin/discharge')?>?order=name&q=<?=$search?>&page=<?=$activepage?>&active=<?=$act?>">Name</a></th>
                <th><a href="<?=base_url('admin/discharge')?>?order=city&q=<?=$search?>&page=<?=$activepage?>&active=<?=$act?>">City</a></th>
                <th><a href="<?=base_url('admin/discharge')?>?order=street&q=<?=$search?>&page=<?=$activepage?>&active=<?=$act?>">Street</a></th>
                <th><a href="<?=base_url('admin/discharge')?>?order=postal_code&q=<?=$search?>&page=<?=$activepage?>&active=<?=$act?>">Postal Code</a></th>
                <th>Functions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($restaurants as $r) {
                echo "<tr>";
                echo "<td>" .$r['id'].  "</td>";
                echo "<td>" .$r['name'].  "</td>";
                echo "<td>" .$r['city'].  "</td>";
                echo "<td>" .$r['street'].  "</td>";
                echo "<td>" .$r['postal_code'].  "</td>";
                echo "<td> 
                <a class='btn btn-primary' role='button' href='".base_url('admin/discharge/'. $r['id'])."'>
                Discharge</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Paginate -->
    <div style='margin-top: 10px;'>
        <?= $pager->only(['q','order','active'])->links() ?>
    </div>

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