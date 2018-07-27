<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\User as User;

class Settings extends Controller {

    public function main() {

        // check auth
        if ($this->authTest()) {

            $payloads = $this->model->getPayloadsByType($_SESSION['userdata']['id'], 'Javascript');

            $user_settings = $this->model->getUserSettings($_SESSION['userdata']['id']);
            $default_payload = $user_settings->default_payload;
        }
        else
            Main::redirect('/');

        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/settings.php';
        require APP . 'view/standard/include/footer.php';
    }

    public function password() {

        if ($this->authTest()) {

            if(!empty($_POST['current']) && !empty($_POST['new']) && !is_array($_POST['current']) && !is_array($_POST['new'])) {

                if (!empty($_POST['token']) && !empty($_SERVER['HTTP_X_CSRF_PROTECTION']) && !is_array($_POST['token'])) {

                    if (Main::csrf_protection($_POST['token'], $_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                        $account = $this->model->getUser($_SESSION['userdata']['name']);
                        $password = trim($_POST['current']);

                        if (User::getHash('sha256', $password, $account->salt) === $account->passwd) {

                            $salt = User::saltGenerate();
                            $new_passwd = User::getHash('sha256', trim($_POST['new']), $salt);
                            $user = $_SESSION['userdata']['id'];

                            if ($new_passwd) {

                                $result = $this->model->updatePasswd($user, $new_passwd, $salt);

                                if ($result) {
                                    Main::status('Password changed!', True);
                                }
                                else
                                    Main::status('Could not change password. Please, try again!');
                            }
                            else
                                Main::status('Could not change password. Please, try again!');
                        }
                        else
                            Main::status('Check your current password please!');
                    }
                    else
                        Main::status('CSRF token is not valid!');
                }
                else
                    Main::status('CSRF token is not valid!');
            }
            else
                Main::status('Check input and try again!');
        }
        else
            Main::redirect('/');
    }

    public function payload() {

        if ($this->authTest()) {

            if (!empty($_POST['payload']) && !is_array($_POST['payload'])) {

                if (!empty($_POST['token']) && !is_array($_POST['token']) && !empty($_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                    if (Main::csrf_protection($_POST['token'], $_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                        $payload = $this->model->getPayloadById($_SESSION['userdata']['id'], trim($_POST['payload']));

                        if ($payload) {

                            if ($payload->type === 'Javascript') {

                                $result = $this->model->updateUserSettings($_SESSION['userdata']['id'], trim($_POST['payload']));

                                if ($result)
                                    Main::status('Settings updated!', True);
                                else
                                    Main::status('Database error. Please, try again!');
                            }
                            else
                                Main::status('Payload type is wrong!');
                        }
                        else
                            Main::status('Payload id is not valid!');

                    }
                    else
                        Main::status('CSRF token is not valid!');

                }
                else
                    Main::status('CSRF token is not valid!');

            }
            else
                Main::status('Check input and try again pls!');
        }
        else
            Main::redirect('/');
    }
}
