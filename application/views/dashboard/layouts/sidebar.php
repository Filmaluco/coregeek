<?php
    switch ($group){
        case 'Admin':
            echo $this->navigation_menu->admin_menu();
            break;
        default:
            echo $this->navigation_menu->default_menu();
    }
?>