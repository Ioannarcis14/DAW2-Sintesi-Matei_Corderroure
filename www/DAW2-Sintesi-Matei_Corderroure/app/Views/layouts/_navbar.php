<nav class="navbar navbar-expand-md navbar-dark nav fixed-top">
    <?php
    $imageProperties = [
        'src'    => 'img/pickeat-bg (1).png',
        'class'  => 'brand_img first',
    ]; ?>
    <a class="navbar-brand" href="#"><?=img($imageProperties)?></a>
    <?php
    $imageProperties = [
        'src'    => 'img/pickeat-text.png',
        'class'  => 'brand_img',
    ]; ?>
    <a class="navbar-brand" href="#"><?=img($imageProperties)?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse text-right" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active d-flex">
                <a class="nav-link mr-5" href="/contact"><?=lang('Contact')?> <span class="sr-only">(<?=lang('Auth.current')?>)</span></a>
                <?php if ($logged == false) {
                    echo "<a class='nav-link' href='/login'>".lang('Log in'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a>";
                } else {
                    echo "<a class='nav-link mr-5' href='/user'>".lang('Profile'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a>";
                    echo "<a class='nav-link' href='/logout'>".lang('Log Out'). "<span class='sr-only'>". (lang('Auth.current')) ."</span></a>";

                } ?>
            </li>
        </ul>
    </div>
</nav>
