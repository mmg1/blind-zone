<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db) {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function getUser($login) {
        $sql = "SELECT * FROM Users WHERE BINARY name = :login";
        $query = $this->db->prepare($sql);
        $parameters = array(':login' => $login);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM Users WHERE BINARY email = :email";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function registerUser($name, $hash, $salt, $email, $type) {
        $sql = "INSERT INTO Users (name, passwd, salt, email, type) VALUES (:name, :passwd, :salt, :email, :type)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            ':name' => $name,
            ':passwd' => $hash,
            ':salt' => $salt,
            ':email' => $email,
            ':type' => $type
        );
 
        $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function getPayloads($user_id) {
        $sql = "SELECT * FROM Payloads WHERE user_id = :user_id OR user_id = 0";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getPayloadsByType($user_id, $type) {
        $sql = "SELECT * FROM Payloads WHERE (user_id = :user_id OR user_id = 0) AND type = :type";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id, ':type' => $type);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function addPayload($name, $payload, $type, $user_id) {
        $sql = "INSERT INTO Payloads (name, payload, type, user_id) VALUES (:name, :payload, :type, :user_id)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            'name' => $name,
            'payload' => $payload,
            'type' => $type,
            'user_id' => $user_id
        );

        $result = $query->execute($parameters);

        return $result;
    }

    public function getProjects($id) {
        $sql = "SELECT * FROM Projects WHERE user = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array('id' => $id));

        return $query->fetchAll();
    }

    public function addProject($name, $user) {
        $sql = "INSERT INTO Projects (name, user) VALUES (:name, :user)";
        $query = $this->db->prepare($sql);
        $parameters = array(
            'name' => $name,
            'user' => $user
        );

        $result = $query->execute($parameters);

        return $result;
    }

    public function getProjectById($id, $user) {
        $sql = "SELECT * FROM Projects WHERE id = :id && user = :user";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $id, 'user' => $user);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getLinksByProject($id, $user) {
        $sql = "SELECT * FROM Links WHERE project = :id && user = :user";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $id, 'user' => $user);

        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getLinks($user) {
        $sql = "SELECT * FROM Links WHERE user = :id";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $user);

        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function createLink($name, $description, $path   , $project, $user, $payload) {
        $sql = "INSERT INTO 
                    Links (name, description, path, project, user, payload) 
                VALUES 
                    (:name, :description, :path, :project, :user, :payload)";

        $query = $this->db->prepare($sql);
        $parameters = array(
            'name' => $name,
            'description' => $description,
            'path' => $path,
            'project' => $project,
            'user' => $user,
            'payload' => $payload
        );

        $result = $query->execute($parameters);

        return $result;
    }

    public function getLinkById($id, $projectId, $user) {
        $sql = "SELECT * FROM Links WHERE id = :id && project = :projectId && user = :user";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $id, 'projectId' => $projectId, 'user' => $user);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getLinkByPath($path) {
        $sql = "SELECT * FROM Links WHERE path = :path";
        $query = $this->db->prepare($sql);
        $parameters = array('path' => $path);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function saveRequest($link) {
        $sql = "INSERT INTO Requests (link) VALUES (:link)";
        $query = $this->db->prepare($sql);
        $parameters = array('link' => $link);

        $result = $query->execute($parameters);

        return $this->db->lastInsertId();
    }

    public function saveClientData($id, $data) {
        $sql = "INSERT INTO ClientData (user_agent, html, url, cookie, request, local_storage, session_storage) VALUES (:user_agent, :html, :url, :cookie, :request, :local_storage, :session_storage)";
        $query = $this->db->prepare($sql);
        $parameters = array('user_agent' => $data['USER_AGENT'],
                            'html' => $data['HTML'],
                            'url' => $data['URL'],
                            'cookie' => $data['COOKIE'],
                            'request' => $id,
                            'local_storage' => $data['LOCAL_STORAGE'],
                            'session_storage' => $data['SESSION_STORAGE']
                        );

        $result = $query->execute($parameters);

        return $result;
    }

    public function saveRequestData($id, $headers, $ip) {
        $sql = "INSERT INTO RequestData (headers, ip, request) VALUES (:headers, :ip, :request)";
        $query = $this->db->prepare($sql);
        $parameters = array('headers' => $headers, 'ip' => $ip, 'request' => $id);

        $result = $query->execute($parameters);

        return $result;
    }

    public function getRequests($link_id) {
        $sql = "SELECT * FROM Requests WHERE link = :id";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $link_id);

        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getClientDataById($id){
        $sql = "SELECT user_agent, html, url, cookie FROM ClientData WHERE request = :id";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getRequestDataById($id) {
        $sql = "SELECT headers, ip FROM RequestData WHERE request = :id";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getSiteSettings() {
        $sql = "SELECT * FROM SiteSettings";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetch();
    }

    public function updatePasswd($user, $passwd, $salt) {
        $sql = "UPDATE Users SET passwd = :passwd, salt = :salt WHERE id = :user";
        $query = $this->db->prepare($sql);
        $parameters = array('passwd' => $passwd, 'salt' => $salt, 'user' => $user);

        $result = $query->execute($parameters);

        return $result;
    }

    public function getLinksCount($projectId) {
        $sql = "SELECT count(*) as total FROM Links WHERE project = :id";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $projectId);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getInteractionsCount($linkId) {
        $sql = "SELECT count(*) as total FROM Requests WHERE link = :id";
        $query = $this->db->prepare($sql);
        $parameters = array('id' => $linkId);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getPayloadById($user_id, $payload_id) {
        $sql = "SELECT * FROM Payloads WHERE (user_id = :user_id OR user_id = 0) AND id = :payload_id";
        $query = $this->db->prepare($sql);
        $parameters = array('user_id' => $user_id, 'payload_id' => $payload_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getPayload($payload_id) {
        $sql = "SELECT * FROM Payloads WHERE id = :payload_id";
        $query = $this->db->prepare($sql);
        $parameters = array('payload_id' => $payload_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function updateSettings($registration) {
        $sql = "UPDATE SiteSettings SET registration = :registration";
        $query = $this->db->prepare($sql);
        $parameters = array('registration' => $registration);

        $result = $query->execute($parameters);

        return $result;
    }

    public function getUserSettings($user_id) {
        $sql = "SELECT * FROM UserSettings WHERE user_id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array('user_id' => $user_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function updateUserSettings($user_id, $payload_id) {
        $sql = "UPDATE UserSettings SET default_payload = :payload_id WHERE user_id = :user_id";
        $query = $this->db->prepare($sql);
        $parameters = array('payload_id' => $payload_id, 'user_id' => $user_id);

        $result = $query->execute($parameters);

        return $result;
    }

    public function createUserSettings($user_id) {
        $sql = "INSERT INTO UserSettings (user_id, default_payload) VALUES (:user_id, 0)";
        $query = $this->db->prepare($sql);
        $parameters = array('user_id' => $user_id);

        $result = $query->execute($parameters);

        return $result;

    }

}
