<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\Session as Session;

class Logout extends Controller {

    public function main() {

        // unset session and redirect to root
        if(!empty($_SESSION['userdata'])) {
            if(Session::sessionDestroy('userdata'))
                Main::redirect('/');
            else {
                $error = 'Can not destroy session!';
                Main::status($error);
            }
        }
        else
            Main::redirect('/');    
    }
}
