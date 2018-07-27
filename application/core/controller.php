<?php

class Controller
{
    public $db = null;
    public $model = null;

    function __construct() {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    private function openDatabaseConnection() {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    protected function loadModel() {
        require APP . 'model/model.php';
        $this->model = new Model($this->db);
    }

    protected function authTest($access_check = 0) {
        if (empty($_SESSION['userdata']))
            return false;

        $account = $this->model->getUser($_SESSION['userdata']['name']);

        if ($account === false) {
            unset($_SESSION['userdata']);
            return false;
        }
        elseif ($access_check == 1 && $account->type !== 'administrator')
            return false;

        return true;
    }
}

