<?php
namespace App\Controllers;

use App\Helpers\JWTHandler;
use App\Models\User;

class ApiController
{
    private $jwtHandler;

    public function __construct()
    {
        $this->jwtHandler = new JwtHandler();
    }

    public function authenticateRequest()
    {
        // Get Authorization header
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            $this->sendResponse(401, ['message' => 'Authorization header missing']);
            exit;
        }

        // Extract token
        $token = str_replace('Bearer ', '', $headers['Authorization']);

        // Validate token
        $payload = $this->jwtHandler->validateToken($token);
        if (!$payload) {
            $this->sendResponse(401, ['message' => 'Invalid or expired token']);
            exit;
        }

        return $payload; // Return decoded payload for further use
    }

    public function sendResponse($statusCode, $data)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // Return list of users in JSON format
    public function users()
    {
        // Make sure user is authenticated. Add this line to protected api routes or when user should be authenticated
        $this->authenticateRequest();

        // Fetch all users using the User model
        $users = User::findAll();

        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                'user_id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
                'image_url' => $user->image_url, // Assuming the user has a picture attribute
            ];
        }

        // Set the content type to JSON and return the response
        header('Content-Type: application/json');
        echo json_encode($userData);
    }

    // Api login
    public function login($params)
    {
        $user = new User();
        $user->email = $params['email'] ?? null;
        $user->password = $params['password'] ?? null;

        if ($user->login()) {
            $token = $this->jwtHandler->generateToken(['user_id' => $user->user_id, 'email' => $user->email ]);
            echo json_encode([
                'message' => 'Login successful',
                'token' => $token,
                'user' => ['user_id' => $user->user_id, 'email'=> $user->email ]
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid email or password']);
        }
        exit;
    }
}