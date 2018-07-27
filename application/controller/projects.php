<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\Link as Link;

class Projects extends Controller {

    public function main() {

        // check auth
        if ($this->authTest()) {

            $projects = $this->model->getProjects($_SESSION['userdata']['id']);

            $links_count = Array();

            foreach($projects as $project) {
                $links_count[$project->id]['count'] = $this->model->getLinksCount($project->id);
            }

            if (!empty($_POST['name']) && !empty($_POST['token']) && !empty($_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                if(!is_array($_POST['name'])) {

                    if (Main::csrf_protection($_POST['token'], $_SERVER['HTTP_X_CSRF_PROTECTION'])) {

                        if (Main::validate_vars($_POST['name'])) {

                            if (mb_strlen($_POST['name']) <= 140) {

                                $result = $this->model->addProject(
                                    trim($_POST['name']),
                                    $_SESSION['userdata']['id']
                                );

                                if ($result)
                                    return Main::status('Project added!', True);
                                else
                                    return Main::status('Database error. Please, try again');
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
                else
                    Main::status('Please, check your input and try again!');
            }
        }
        else
            Main::redirect('/');

        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/projects.php';
        require APP . 'view/standard/include/footer.php';
    }

    // $project = INT, id of project
    // $site = INT, site of project
    // method for getting created links for project
    public function view($projectId, $site = 0) {

        if ($this->authTest()) {

            if (!empty($projectId) && is_numeric($projectId) && $projectId > 0) {

                // TODO: possible to get all project by id for administrator
                $project = $this->model->getProjectById((int)$projectId, $_SESSION['userdata']['id']);

                if ($project) {
                    // get links by project
                    $links = $this->model->getLinksByProject((int)$projectId, $_SESSION['userdata']['id']);

                    // get payloads
                    $payloads = $this->model->getPayloadsByType($_SESSION['userdata']['id'], 'Javascript');

                    // get default payload id from site settings
                    $site_settings = $this->model->getUserSettings($_SESSION['userdata']['id']);
                    $default_payload = $site_settings->default_payload;

                    $interactions_count = Array();

                    foreach ($links as $link) {
                        $interactions_count[$link->id]['count'] = $this->model->getInteractionsCount($link->id);
                    }

                    $random_path = Link::generate_path();
                }
                else
                    return Main::status('Not found! (:');
            }
        }
        else
            Main::redirect('/');

        // load views
        require APP . 'view/standard/include/header.php';
        require APP . 'view/standard/links.php';
        require APP . 'view/standard/include/footer.php';
    }
}
