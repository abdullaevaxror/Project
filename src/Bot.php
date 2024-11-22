<?php
use GuzzleHttp\Client;
require 'DB.php';
require 'vendor/autoload.php';
class Bot
{
    const API_URL = 'https://api.telegram.org/bot';
    private $token = "7880690621:AAHslFJRJV-e99q2reqrEKJ0OVzQfOyyF0c";
    public $client;

    public function makeRequest($method, $data = [])
    {
        $this->client = new Client([
            'base_uri' => self::API_URL . $this->token . '/',
            'timeout' => 2.0,
        ]);

        $request = $this->client->request('POST', $method, ['json' => $data]);

        return json_decode($request->getBody()->getContents());
    }
    public function saveUser($user_id, $username): bool {
        var_dump($this->getUser($user_id));

        if ($this->getUser($user_id)) {
            return false;
        }
        $query = "INSERT INTO tg_users (user_id, username) VALUES (:user_id, :username)";
        $db = new DB();
        return $db->conn->prepare($query)->execute([
            ':user_id' => $user_id,
            ':username' => $username
        ]);
    }
    public function getUser($user_id):bool|array {
        $query = "SELECT * FROM tg_users WHERE user_id = :user_id";
        $db = new DB();
        $stmt = $db->conn->prepare($query);
        $stmt->execute([
            ':user_id' => $user_id
        ]);
        return $stmt->fetch();
    }

}
?>