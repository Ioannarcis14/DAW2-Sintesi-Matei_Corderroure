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
    <form method='get' action="<?= base_url('admin/messages'); ?>" id="searchForm">
        <input type='text' name='q' value='<?= $search ?>' placeholder="Search here...">
        <input type='button' id='btnsearch' value='Cercar' onclick='document.getElementById("searchForm").submit();'>
    </form>
    <br />

    <table class="table table-hover" style='border-collapse: collapse;'>
        <thead>
            <tr>
                <th><a href="<?=base_url('admin/messages')?>?order=id_user&q=<?=$search?>&page=<?=$activepage?>&active=<?=$act?>">Sender</a></th>
                <th><a href="<?=base_url('admin/messages')?>?order=theme&q=<?=$search?>&page=<?=$activepage?>&active=<?=$act?>">Theme</a></th>
                <th><a href="<?=base_url('admin/messages')?>?order=message&q=<?=$search?>&page=<?=$activepage?>&active=<?=$act?>">Message</a></th>
                <th><a class='btn btn-primary' role='button' href="<?php echo base_url("admin/messages/send")?>">Send a message</a></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($messages as $m) {
                echo "<tr>";
                echo "<td>" . $m['id_user'].  "</td>";
                echo "<td>" . $m['theme'].  "</td>";
                echo "<td>" . $m['message'].  "</td>";
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