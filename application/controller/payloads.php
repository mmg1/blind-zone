<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\User as User;

class Payloads extends Controller {

    public function main() {

        if ($this->authTest()) {
            $payloads = $this->model->getPayloads($_SESSION['userdata']['id']);

            if (!empty($_POST['payload']) && !empty($_POST['name']) && !empty($_POST['type']) &&
                !empty($_POST['token']) && !empty($_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                if (Main::csrf_protection($_POST['token'], $_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                    $user_id = $_SESSION['userdata']['id'];

                    if (!empty($_POST['public']) && !is_array($_POST['public']) && $_SESSION['userdata']['type'] === 'administrator')
                        $user_id = 0;

                    if (Main::validate_vars($_POST['name'], $_POST['payload'], $_POST['type'])) {

                        if (mb_strlen($_POST['name']) <= 140) {

                            if (mb_strlen($_POST['type']) <= 140) {

                                $result = $this->model->addPayload(
                                    trim($_POST['name']),
                                    trim($_POST['payload']),
                                    trim($_POST['type']),
                                    $user_id
                                );
                                if ($result)
                                    Main::status('Payload added!', true);
                                else
                                    Main::status('Database error. Please, try again');
                            }
                            else
                                Main::status('Max length for type is 140 symbols!');
                        }
                        else
                            Main::status('Max length for name is 140 symbols!');
                    }
                    else
                        Main::status('Check input and try again!');
                }
                else
                    Main::status('CSRF token is not valid!');
            }
        }
        else
            Main::redirect('/');

        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/payloads.php';
        require APP . 'view/standard/include/footer.php';
    }
}
