<?php
defined('BASEPATH') or exit('No direct script access allowed');


use chriskacerguis\RestServer\RestController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class LoginController extends RestController
{
    private $key;
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('User', 'user');
        $this->key = '1234567890';
    }

    // Login dan kirim token
    public function index_post()
    {
        
        $date = new DateTime();
        $username = $this->post('username');
        $password = $this->post('password');
        $encrypt_pass = hash('sha512', $password . $this->key);

        $user = $this->user->doLogin($username, $encrypt_pass);
        if ($user) {
            $payload = [
                'id' => $user[0]->id,
                'name' => $user[0]->name,
                'username' => $user[0]->username,
                'iat' => $date->getTimestamp(), // created_at
                'exp' => $date->getTimestamp()+(60*300), // token 300 menit
            ];
            $token = JWT::encode($payload, $this->key, 'HS256');
            $this->response([
                'status' => true,
                'message' => 'Login berhasil',
                'result' => [
                    'id' => $user[0]->id,
                    'name' => $user[0]->name,
                    'username' => $user[0]->username,
                ],
                'token' => $token,
            ], self::HTTP_OK);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Username dan password salah!',
            ], self::HTTP_FORBIDDEN);
        }
    }

    // Validasi Token
    protected function checkToken(){
        $jwt = $this->input->get_request_header('Authorization');
        try{
            JWT::decode($jwt, new Key ($this->key, 'HS256'));
        }catch(Exception $e){
            $this->response([
                'status' => false,
                'message' => 'Invalid token',
            ], self::HTTP_UNAUTHORIZED);
        }
    }
}
