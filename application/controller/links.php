<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\Link as Link;

class Links extends Controller {

    public function main() {

        // check auth
        if ($this->authTest()) {
            $links = $this->model->getLinks($_SESSION['userdata']['id']);

            if ($links) {

                $requests_data = array();

                foreach ($links as $link) {

                    $data = $this->model->getRequests($link->id);

                    if ($data) {
                        $request_data = array();

                        for ($i = 0; $i < count($data); $i++) {

                            $request_data[$i]['project_id'] = $link->project;
                            $request_data[$i]['link_id'] = $link->id;
                            $request_data[$i]['link_name'] = $link->name;
                            // request's date
                            $request_data[$i]['date'] = $data[$i]->date;

                            // client's data
                            $client_data = $this->model->getClientDataById($data[$i]->id);

                            $request_data[$i]['url'] = (!empty($client_data->url))?$client_data->url:'Unknown URL';
                            $request_data[$i]['user_agent'] = (!empty($client_data->user_agent))?$client_data->user_agent:'Empty user-agent';
                            $request_data[$i]['html'] = (!empty($client_data->html))?$client_data->html:'Empty';
                            $request_data[$i]['cookie'] = (!empty($client_data->cookie))?$client_data->cookie:'Empty cookies';
                            $request_data[$i]['session_storage'] = (!empty($client_data->session_storage))?$client_data->session_storage:'Empty session storage';
                            $request_data[$i]['local_storage'] = (!empty($client_data->local_storage))?$client_data->local_storage:'Empty local storage';

                            // request's data
                            $request = $this->model->getRequestDataById($data[$i]->id);

                            $request_data[$i]['headers'] = json_decode((!empty($request->headers))?$request->headers:'{}', true);
                            $request_data[$i]['ip'] = (!empty($request->ip))?$request->ip:'Empty IP';

                            $requests_data[count($requests_data)] = $request_data[$i];

                        }
                    }
                }
            }
        }
        else
            Main::redirect('/');

        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/list.php';
        require APP . 'view/standard/include/footer.php';
    }

    /**
     * @param int $projectId
     * @param int $linkId
     */
    public function view($projectId = 0, $linkId = 0) {

        if ($this->authTest()) {

            if (!empty($projectId) && is_numeric($projectId) && $projectId > 0 &&
                !empty($linkId) && is_numeric($linkId) && $linkId > 0)
            {

                // TODO: possible to get all project by id for administrator
                $project = $this->model->getProjectById((int)$projectId, $_SESSION['userdata']['id']);

                if ($project) {
                    // get links by project
                    $link = $this->model->getLinkById((int)$linkId, (int)$projectId, $_SESSION['userdata']['id']);

                    if ($link) {
                        $data = $this->model->getRequests($link->id);
                        $requests_data = array();

                        if ($data) {
                            $request_data = array();
                            $random_path = Link::generate_path();

                            for($i = 0; $i < count($data); $i++) {

                                // request's date
                                $request_data[$i]['date'] = $data[$i]->date;

                                // client's data
                                $client_data = $this->model->getClientDataById($data[$i]->id);

                                $request_data[$i]['url'] = (!empty($client_data->url))?$client_data->url:'Unknown URL';
                                $request_data[$i]['user_agent'] = (!empty($client_data->user_agent))?$client_data->user_agent:'Empty user-agent';
                                $request_data[$i]['html'] = (!empty($client_data->html))?$client_data->html:'Empty';
                                $request_data[$i]['cookie'] = (!empty($client_data->cookie))?$client_data->cookie:'Empty cookies';
                                $request_data[$i]['session_storage'] = (!empty($client_data->session_storage))?$client_data->session_storage:'Empty session storage';
                                $request_data[$i]['local_storage'] = (!empty($client_data->local_storage))?$client_data->local_storage:'Empty local storage';

                                // request's data
                                $request = $this->model->getRequestDataById($data[$i]->id);

                                $request_data[$i]['headers'] = json_decode((!empty($request->headers))?$request->headers:'{}', true);
                                $request_data[$i]['ip'] = (!empty($request->ip))?$request->ip:'Empty IP';

                                $requests_data[count($requests_data)] = $request_data[$i];
                            }

                        }
                    }
                    else
                        Main::status('Not found!');
                }
                else
                    Main::status('Not found!');
            }
            else
                Main::status('Not found!');
        }
        else
            Main::redirect('/');

        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/link.php';
        require APP . 'view/standard/include/footer.php';
    }

    /**
     * @param int $projectId
     */
    public function create($projectId = 0) {
        if ($this->authTest()) {

            if (!empty($projectId) && is_numeric($projectId) && $projectId > 0) {

                $project = $this->model->getProjectById((int)$projectId, $_SESSION['userdata']['id']);

                if ($project) {

                    if (!empty($_POST['token']) && !empty($_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                        if(Main::csrf_protection($_POST['token'], $_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                            if(!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['payload'])) {

                                if (Main::validate_vars($_POST['name'], $_POST['description'], $_POST['payload'])) {

                                    if(mb_strlen($_POST['name']) <= 140) {

                                        if (mb_strlen($_POST['description']) <= 1024) {

                                            $payload = $this->model->getPayloadById($_SESSION['userdata']['id'], trim($_POST['payload']));

                                            if ($payload && $payload->type === 'Javascript') {

                                                $random_path = Link::generate_path();

                                                $result = $this->model->createLink(
                                                    trim($_POST['name']),
                                                    trim($_POST['description']),
                                                    $random_path,
                                                    (int)$projectId,
                                                    $_SESSION['userdata']['id'],
                                                    $payload->id
                                                );

                                                if ($result)
                                                    Main::status('Link created', True);
                                                else
                                                    Main::status('Database error. Please, try again!');
                                            }
                                            else
                                                Main::status('Payload is wrong!');
                                        }
                                        else
                                            Main::status('Max length for description is 1024 symbols!');
                                    }
                                    else
                                        Main::status('Max length for name is 140 symbols!');
                                }
                                else
                                    Main::status('Check input and try again!');
                            }
                            else
                                Main::status('Name, description or payload is empty!');
                        }
                        else
                            Main::status('CSRF token is not valid!');
                    }
                    else
                        Main::status('CSRF token is not valid!');
                }
                else
                    Main::status('Not found! (:');
            }
        }
        else
            Main::redirect('/');
    }
}
