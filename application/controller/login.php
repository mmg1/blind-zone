<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\User as User;
use Blind\Session as Session;

class Login extends Controller {

    public function main() {

        if ($this->authTest())
            Main::redirect('/');
        elseif (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['token'])) {

            if (!is_array($_POST['login']) && !is_array($_POST['password']) && !is_array($_POST['token'])) {

                if ($_POST['token'] === $_SERVER['HTTP_X_CSRF_PROTECTION']) {

                    if ($_SERVER['HTTP_X_CSRF_PROTECTION'] === $_SESSION['token']) {

                        $login = trim($_POST['login']);

                        if ($login) {
                            $account = $this->model->getUser($login);

                            if ($account) {
                                $password = trim($_POST['password']);

                                if (User::getHash('sha256', $password, $account->salt) === $account->passwd) {
                                    $userdata = array(
                                        'id' => $account->id,
                                        'name' => $account->name,
                                        'type' => $account->type
                                    );

                                    Session::sessionRegenerate();
                                    $_SESSION['userdata'] = $userdata;

                                    Main::status('Successful login!', true);
                                }
                                else
                                    Main::status('Name or password is not correct!');
                            }
                            else
                                Main::status('Name or password is not correct!');
                        }
                        else
                            Main::status('Please, check your input and try again!');
                    }
                    else
                        Main::status('CSRF token is not valid!');
                }
                else
                    Main::status('CSRF token is not valid!');
            }
            else
                Main::status('Please, check your input and try again!');
        }

        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/login.php';
        require APP . 'view/standard/include/footer.php';
    }
}
