<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Restaurant</title>
    <link rel="stylesheet" href="<?= base_url('/css/normalize.css')?>">
    <link rel="stylesheet" href="<?= base_url('/css/main.css')?>" media="screen" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?= base_url('/css/bootstrap.css')?>">
    <link rel="stylesheet" href="<?= base_url('/css/style-portfolio.css')?>">
    <link rel="stylesheet" href="<?= base_url('/css/picto-foundry-food.css')?>" />
    <link rel="stylesheet" href="<?= base_url('/css/jquery-ui.css')?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url('/css/font-awesome.min.css')?>" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="min-height: 60px !important;
    max-height: 60px;">
    <div style="padding-left: 15px; padding-right: 15px;">
        <div class="row">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php
                $imageProperties = [
                'src'    => 'img/pickeat-text.png',
                'height'  => '30px',
                'style'  => 'margin-top: -14px; padding-left: 7px'
                ]; ?>
                <a class="navbar-brand" style="padding: 10px" href="/"><?=img($imageProperties)?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" style="padding-right: 30px">
                <ul class="nav navbar-nav main-nav  clear navbar-right ">
                    <li><a class="navactive color_animation" href="#top">WELCOME</a></li>
                    <li><a class="color_animation" href="#story">ABOUT</a></li>
                    <li><a class="color_animation" href="#pricing">MENU</a></li>
                    <?php 
                    if($logged == true) {
                    echo '<li><a    class="color_animation" href="#valorations">VALORATIONS</a></li>';
                    } 
                    ?>
<!--                    <li><a class="color_animation" href="restaurants">RESTAURANTS</a></li>-->
<!---->
<!--                    --><?php //if ($logged == false) {
//                        echo "<li><a class='color_animation' href='/login'>".lang('LOG IN'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
//                    } else {
////                        echo "<li><a class='color_animation' href='/user'>".lang('PROFILE'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
//                        echo "<li><a class='color_animation' href='/logout'>".lang('LOG OUT'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
//                    } ?>

                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </div><!-- /.container-fluid -->
</nav>

<div id="top" class="starter_container bg">
    <div class="follow_container">
        <div class="col-md-6 col-md-offset-3">
            <h2 class="top-title"> Restaurant</h2>
            <h2 class="white second-title">" Best in the city "</h2>
            <hr>
        </div>
    </div>
</div>

<!-- ============ About Us ============= -->

<section id="story" class="description_content">
    <div class="text-content container">
        <div class="col-md-6">
            <h1>About us</h1>
            <div class="fa fa-cutlery fa-2x"></div>
            <p class="desc-text">Restaurant is a place for simplicity. Good food, good beer, and good service. Simple is the name of the game, and we’re good at finding it in all the right places, even in your dining experience. We’re a small group from Denver, Colorado who make simple food possible. Come join us and see what simplicity tastes like.</p>
        </div>
        <div class="col-md-6">
            <div class="img-section">
                <?php
                $imageProperties2 = [
                'src'    => 'img/demo_rest.jpg',
                'width'  => '250px',
                'height' => '220px'
                ]; ?>

                <?= img($imageProperties2); ?>
                <?= img($imageProperties2); ?>
                <div class="img-section-space"></div>
                <?= img($imageProperties2); ?>
                <?= img($imageProperties2); ?>
            </div>
        </div>
    </div>
</section>


<!-- ============ Pricing  ============= -->


<section id ="pricing" class="description_content">
    <div class="pricing background_content">
        <h1>Our <span>Menu</span> </h1>
    </div>
    <div class="text-content container">
        <div class="container">
            <div class="row">
                <div id="w">
                    <ul id="filter-list" class="clearfix">
                        <li class="filter" data-filter="all">All</li>
                        <li class="filter" data-filter="breakfast">Breakfast</li>
                        <li class="filter" data-filter="special">Special</li>
                        <li class="filter" data-filter="desert">Desert</li>
                        <li class="filter" data-filter="dinner">Dinner</li>
                    </ul><!-- @end #filter-list -->
                    <ul id="portfolio">
                        <li class="item breakfast"><?= img('img/dish.jpg');?>
                            <h2 class="white">$20</h2>
                        </li>

                        <li class="item dinner special"><?= img('img/dish2.jpg');?>
                            <h2 class="white">$20</h2>
                        </li>
                        <li class="item dinner breakfast"><?= img('img/dish.jpg');?>
                            <h2 class="white">$18</h2>
                        </li>
                        <li class="item special"><?= img('img/dish2.jpg');?>
                            <h2 class="white">$15</h2>
                        </li>
                        <li class="item dinner"><?= img('img/dish2.jpg');?>
                            <h2 class="white">$20</h2>
                        </li>
                        <li class="item special"><?= img('img/dish2.jpg');?>
                            <h2 class="white">$22</h2>
                        </li>
                        <li class="item desert"><?= img('img/dish.jpg');?>
                            <h2 class="white">$32</h2>
                        </li>
                        <li class="item desert breakfast"><?= img('img/dish.jpg');?>
                            <h2 class="white">$38</h2>
                        </li>
                    </ul><!-- @end #portfolio -->
                </div><!-- @end #w -->
            </div>
        </div>
    </div>
</section>


<!-- ============ Our Beer  ============= -->


<section id ="beer" class="description_content">
    <div  class="beer background_content">
        <h1>Great <span>Place</span> to enjoy</h1>
    </div>
</section>

<!-- ============ Display Valorations  ============= -->



<!-- ============ Make a Valoration  ============= -->

<?php 
if($logged == true) {
    echo '<section id ="createValorations " class="description_content">
            <div  class="createValorations">
            <h1>Make a valoration</h1>
                    <div class="form-group">
                        <label for="rating">'.lang('Auth.rating').'</label>
                        <input type="range" min="0" max="10" id="rating" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="observation">'.lang('Auth.observation').'</label>
                        <input type="text" id="observation" class="form-control">
                    </div>
                    <button class="btn btn-primary" onclick="makeValorations()" value="Valorate">
    </div>
</section>';
}

?>


<!-- ============ Our Bread  ============= -->



<footer class="sub_footer">
    <div class="container">
        <div class="col-md-4"><p class="sub-footer-text text-center">&copy; PickEat 2022, by <a href="https://themewagon.com/">Joan & Ioan</a></p></div>
        <div class="col-md-4"><p class="sub-footer-text text-center">Back to <a href="#top">TOP</a></p>
        </div>
    </div>
</footer>

<script>
    async function makeValorations(){
        var rating = document.getElementById("rating");
        var observation = document.getElementById("observation");
        var token = window.sessionStorage.getItem("tokenRefresh");

        var response;

        if (token == "" || token == "undefined" || token == null) {
                response = await fetch("<?php echo base_url(); ?>/api/users/createValorations", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + <?php echo '"'.$_SESSION['token'].'"'?>,
                },
                body: JSON.stringify({
                    id_restaurant: <?php echo $id ?>,
                    rating: rating,
                    observation: observation,
                }),
            });
            } else {
                response = await fetch("<?php echo base_url(); ?>/api/users/createValorations", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                body: JSON.stringify({
                    id_restaurant: <?php echo $id ?>,
                    rating: rating,
                    observation: observation,
                }),
            });
            }
            
            response.json().then((data) => {
                if (data.error == false) {
                    document.getElementById("messages").innerHTML = data.messages;
                    window.sessionStorage.setItem("tokenRefresh",data.refreshToken);
                } else {
                    if(data.status != 401) {
                        document.getElementById("messages").innerHTML = data.messages;
                        window.sessionStorage.setItem("tokenRefresh",data.refreshToken);
                    } else {
                        var token = window.sessionStorage.removeItem("tokenRefresh");
                        window.location = "<?php echo base_url(); ?>/logout";
                    }

                }
            }).catch(error => {
                var token = window.sessionStorage.removeItem("tokenRefresh");
                window.location = "<?php echo base_url(); ?>/logout";
            });
    }

</script>

<script type="text/javascript" src="<?= base_url('/js/jquery-1.10.2.min.js')?>"> </script>
<script type="text/javascript" src="<?= base_url('/js/bootstrap.min.js')?>" ></script>
<script type="text/javascript" src="<?= base_url('/js/jquery-1.10.2.js')?>"></script>
<script type="text/javascript" src="<?= base_url('/js/jquery.mixitup.min.js')?>" ></script>
<script type="text/javascript" src="<?= base_url('/js/main.js')?>" ></script>

</body>
</html>