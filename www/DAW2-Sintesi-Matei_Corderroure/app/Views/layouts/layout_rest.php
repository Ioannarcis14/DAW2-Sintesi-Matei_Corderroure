<!doctype html>
<html lang="en" class="restaurant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <?= view('App\layouts\header') ?>

    <?= link_tag('css/styles.css'); ?>
    <title>Restaurant</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

</head>

<body class="restaurant">

<?= view('App\layouts\_navbar') ?>

<main role="main">
    <div class="topContent">
        <?php

//                echo $elem['id'] . "</br>";
//                echo $elem['name'] . "</br>";
//                echo $elem['city'] . "</br>";
//                echo $elem['street'] . "</br>";
//                echo $elem['postal_code'] . "</br>";
//                echo $elem['description'] . "</br>";
//                echo $elem['social_websites'] . "</br>";
//                echo $elem['img_gallery'] . "</br>";
//                echo $elem['discharged'] . "</br>";
//            }
        echo "<div>";
            echo "<div class='event-schedule-area-two bg-color pad100''>";
                echo "<div class='container''>";
                    echo "<div class='row'>";
                        echo "<div class='col-lg-12'>";
                            echo "<div class='tab-content' id='myTabContent'>";
                                echo "<div class='tab-pane fade active show' id='home' role='tabpanel'>";
                                    echo "<div class='table-responsive'>";
                                        echo "<table class='table'>";
                                            echo "<thead>";
                                                echo "<tr>";
                                                    echo "<th scope='col'>Restaurants</th>";
                                                    echo "<th scope='col'></th>";
                                                    echo "<th scope='col'></th>";
                                                    echo "<th class='text-center' scope='col'></th>";
                                                echo "</tr>";
                                            echo "</thead>";
                                            echo "<tbody>";

                                            foreach ($list as $elem) {

                                                echo "<tr class='inner-box'>";
                                                    echo "<td>";
                                                        echo "<div class='event-img''>";
                                                            $img = explode(',', $elem['img_gallery']);
                                                            echo img($img[0]);
                                                        echo "</div>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                        echo "<div class='event-wrap>'";
                                                            echo "<h3><a href=restaurants/".$elem['id'].">".$elem['name']."</a></h3>";
                                                            echo "<div class='meta''>";
                                                                echo "<div class='time''>";
                                                                    echo "<span>".$elem['city']."</span>";
                                                                echo "</div>";
                                                                echo "<div class='organizers'>";
                                                                    echo $elem['postal_code'];
                                                                echo "</div>";
                                                                echo "<div class='categories'>";
                                                                    echo "<b>".$elem['street']."</b>";
                                                                echo "</div>";
                                                            echo "</div>";
                                                        echo "</div>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                        echo "<div class='r-no'>";
                                                        if ($elem['nota'] <= 10 && $elem['nota'] >= 7) {
                                                            echo "<div class='note high'>".intval($elem['nota'])."</div>";
                                                        } elseif ($elem['nota'] < 7 && $elem['nota'] >= 4) {
                                                            echo "<div class='note medium'>" . intval($elem['nota']) . "</div>";
                                                        } elseif ($elem['nota'] < 4 && $elem['nota'] >= 0) {
                                                            echo "<div class='note low'>" . intval($elem['nota']) . "</div>";
                                                        }
                                                        echo "</div>";
                                                        echo "</td>";
                                                    echo "<td>";
                                                        echo "<div class='primary-btn'>";
                                                            echo "<a class='btn btn-primary' href=restaurants/".$elem['id'].">Read More</a>";
                                                        echo "</div>";
                                                    echo "</td>";
                                                echo "</tr>";
                                                }
                                            echo "</tbody>";
                                        echo "</table>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";

    ?>


    </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"> </script>
    <script type="text/javascript" src="js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="js/jquery.mixitup.min.js" ></script>
    <script type="text/javascript" src="js/main.js" ></script>

</body>
</html>
