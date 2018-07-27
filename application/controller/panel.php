<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\User as User;

class Panel extends Controller {

    public function main() {

        if ($this->authTest(1)) {

            if (!empty($_POST['token']) && !empty($_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                if (Main::csrf_protection($_POST['token'], $_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                    if (!empty($_POST['payload'])) {

                        $registration = (!empty($_POST['registration']) && !is_array($_POST['registration'])) ? 1 : 0;

                        if (Main::validate_vars($registration)) {

                            $result = $this->model->updateSettings($registration);

                            if ($result)
                                Main::status('Settings updated!', True);
                            else
                                Main::status('Database error. Please, try again!');
                        } else
                            Main::status('Check input and try again!');
                    } else
                        Main::status('Check input and try again!');
                } else
                    Main::status('CSRF token is not valid!');
            } else {
                $settings = $this->model->getSiteSettings();

                if ($settings->registration == '1')
                    $registration = "checked";
                else
                    $registration = "";
            }
        }
        else
            Main::redirect('/');

        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/panel.php';
        require APP . 'view/standard/include/footer.php';
    }
}
