<?php

function pr($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function jakoo_topbar_add_menu() {
    global $menu, $submenu;
    pr($menu);
    pr($submenu);

}