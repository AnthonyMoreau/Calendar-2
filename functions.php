<?php
function dd($variable){
    ?>
        <pre><?php var_dump($variable) ?></pre>
    <?php
    die();
}