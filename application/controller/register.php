<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\User as User;

class Register extends Controller {

    public function main() {

        if ($this->authTest())
            Main::redirect('/');
        elseif (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['token']) && !empty($_POST['email'])) {

            if (!is_array($_POST['username']) && !is_array($_POST['password']) && !is_array($_POST['token']) && !is_array($_POST['email'])) {

                if ($_POST['token'] === $_SERVER['HTTP_X_CSRF_PROTECTION']) {

                    if ($_SERVER['HTTP_X_CSRF_PROTECTION'] === $_SESSION['token']) {

                        $username = User::checkName($_POST['username']);
                        $email = User::checkEmail($_POST['email']);

                        if (!is_array($_POST['password'])) {

                            $password = trim($_POST['password']);

                            if ($email) {

                                if ($username) {

                                    if (!$this->model->getUser($username)) {
                                        if (!$this->model->getUserByEmail($email)) {

                                            $salt = User::saltGenerate();

                                            $hash = User::getHash('sha256', $password, $salt);
                                            $type = 'simple';

                                            if ($hash) {
                                                $result = $this->model->registerUser($username, $hash, $salt, $email, $type);

                                                $user_settings = $this->model->createUserSettings($result);

                                                if ($result && $user_settings) {

                                                    Main::status('Registration complete!', True);
                                                }
                                                else
                                                    Main::status('Could not register. Please, try again!');
                                            }
                                            else
                                                Main::status('Could not register. Please, try again!');
                                        }
                                        else
                                            Main::status('This e-mail address is busy!');
                                    }
                                    else
                                        Main::status('This name already exists!');
                                }
                                else
                                    Main::status('The length of name must be in range from 1 to 21');
                            }
                            else
                                Main::status('Not a valid e-mail address!');
                        }
                        else
                            Main::status('Password is not valid!');
                    }
                    else
                        Main::status('CSRF token is not valid');
                }
                else
                    Main::status('CSRF token is not valid!');
            }
            else
                Main::status('Please, check your input and try again!');
        }
        else {
            $settings = $this->model->getSiteSettings();

            if ($settings->registration !== '1')
                $registration = 'Registration was closed';
        }

        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/register.php';
        require APP . 'view/standard/include/footer.php';     
    }
}
