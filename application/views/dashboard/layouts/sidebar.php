<?php
    switch ($group){
        case AUTH_GROUP_ADMIN:
            echo $this->navigation_menu->admin_menu();
            break;
        default:
            echo $this->navigation_menu->default_menu();
    }
?>