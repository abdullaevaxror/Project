<?php

use GuzzleHttp\Client;

require 'DB.php';

class Bot
{
    const API_URL = 'https://api.telegram.org/bot';
    private $token;
    private $client;

    public function __construct()
    {
        $this->token = $_ENV['TELEGRAM_BOT_TOKEN'];

        $this->client = new Client([
            'base_uri' => self::API_URL . $this->token . '/',
            'timeout'  => 2.0,
        ]);
    }

    public function makeRequest($method, $data = [])
    {
        try {
            $response = $this->client->request('POST', $method, ['json' => $data]);
            return json_decode($response->getBody()->getContents());
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function sendMessage($chat_id, $message)
    {
        return $this->makeRequest('sendMessage', [
            'chat_id' => $chat_id,
            'text'    => $message,
        ]);
    }

    public function saveUser($user_id, $username): bool
    {
        // Prevent duplicate entries
        if ($this->getUser($user_id)) {
            return false;
        }

        // Insert new user
        $query = "INSERT INTO tg_users (user_id, username) VALUES (:user_id, :username)";
        $db = new DB();
        return $db->conn->prepare($query)->execute([
            ':user_id' => $user_id,
            ':username' => $username,
        ]);
    }

    public function getUser($user_id): bool|array
    {
        // Fetch user by ID
        $query = "SELECT * FROM tg_users WHERE user_id = :user_id";
        $db = new DB();
        $stmt = $db->conn->prepare($query);
        $stmt->execute([
            ':user_id' => $user_id,
        ]);
        return $stmt->fetch();
    }
}

// Usage example
$bot = new Bot();
$chatId = '6222424607'; // Replace with your chat ID
$message = 'Hello from the Telegram bot!';
$bot->sendMessage($chatId, $message);
