<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/auth/LoginController.php';
use chriskacerguis\RestServer\RestController;

class UserController extends LoginController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->checkToken();
        $this->load->model('User', 'user');
        $this->methods['index_get']['limit'] = 10;
    }

    // Index , Show
    public function index_get()
    {
        $id = $this->get('id');

        $data = $this->user->getData($id);
        if ($data) {
            $this->response([
                'status' => true,
                'message' => 'Berhasil mendapatkan data',
                'result' => $data,
            ], self::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak di temukan',
            ], self::HTTP_NOT_FOUND);
        }
    }
}
