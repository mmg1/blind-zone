<?php

class About extends Controller {

    public function main() {
        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/about.php';
        require APP . 'view/standard/include/footer.php';     
    }
}
