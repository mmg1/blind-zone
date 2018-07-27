<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\User as User;

class Index extends Controller {

    public function main() {

        if ($this->authTest()) {
            // do something
        }

        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/home.php';
        require APP . 'view/standard/include/footer.php';
    }
}
