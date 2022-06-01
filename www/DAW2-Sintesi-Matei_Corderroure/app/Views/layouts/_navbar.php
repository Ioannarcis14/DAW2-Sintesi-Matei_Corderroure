<nav class="navbar navbar-expand-md navbar-dark nav fixed-top" style="display: block; min-height: 60px">
    <div class="">
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
                    'class'  => 'brand_img',
                ]; ?>
                <a class="navbar-brand nav navbar-nav main-nav " href="/"><?=img($imageProperties)?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse ml-auto" id="bs-example-navbar-collapse-1 ">
                <ul class="nav navbar-nav main-nav  clear ml-auto">
<!--                    <li><a class="navactive color_animation" href="#top">WELCOME</a></li>-->
<!--                    <li><a class="color_animation" href="#story">ABOUT</a></li>-->
                    <li><a class="color_animation" href="/restaurants">RESTAURANTS</a></li>

                    <?php if ($logged == false) {
                        echo "<li><a class='color_animation' href='/login'>".lang('LOG IN'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
                    } else {
                        if (in_array("administrador",  $groups)) {
                            echo "<li><a class='color_animation' href='/admin/admin/users'>".lang('PROFILE'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
                        }
                        echo "<li><a class='color_animation' href='/user'>".lang('PROFILE'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
                        echo "<li><a class='color_animation' href='/discharge'>".lang('DISCHARGE'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
                        echo "<li><a class='color_animation' href='/contact'>".lang('CONTACT'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
                        echo "<li><a class='color_animation' href='/logout'>".lang('LOG OUT'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a></li>";
                    } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </div><!-- /.container-fluid -->
</nav>
