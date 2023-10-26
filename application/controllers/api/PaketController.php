<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/auth/LoginController.php';
use chriskacerguis\RestServer\RestController;

class PaketController extends LoginController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->checkToken();
        $this->load->model('Paket', 'paket');
        $this->methods['index_get']['limit'] = 10;
    }

    // Index , Show
    public function index_get()
    {
        $id = $this->get('id');

        $data = $this->paket->getData($id);
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

    // Store / Create
    public function index_post()
    {
        // Validasi
        if (!$this->_validationCheck()) {
            $this->response([
                'status' => false,
                'message' => strip_tags(validation_errors()),
            ], self::HTTP_BAD_REQUEST);
        } else {
            $data = [
                'name' => $this->post('name'),
                'resi' => $this->post('resi'),
                'created_at' => date('Y-m-d H:i:s'), // Tanggal saat ini
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $saved = $this->paket->storeData($data);
            if ($saved > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil menambahkan data',
                ], self::HTTP_CREATED);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Gagal menambahkan data',
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }

    // Edit / Update
    public function index_put()
    {
        $this->form_validation->set_data($this->put());

        if (!$this->_validationCheck()) {
            $this->response([
                'status' => false,
                'message' => strip_tags(validation_errors()),
            ], self::HTTP_BAD_REQUEST);
        } else {

            $id = $this->put('id');
            $data = [
                'name' => $this->put('name'),
                'resi' => $this->put('resi'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $updated = $this->paket->updateData($data, $id);
            if ($updated > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil memperbarui data',
                ], self::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Gagal memperbarui data',
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }

    // Destroy / Delete
    public function index_delete()
    {
        $id = $this->delete('id');
        if (!$id) {
            $this->response([
                'status' => false,
                'message' => 'Silakan masukkan id',
            ], self::HTTP_NOT_FOUND);
        } else {
            $deleted = $this->paket->deleteData($id);
            if ($deleted > 0) {
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil menghapus data',
                ], self::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Gagal menghapus data',
                ], self::HTTP_BAD_REQUEST);
            }
        }
    }

    // Validasi
    private function _validationCheck()
    {
        $this->form_validation->set_rules(
            'name',
            'Nama Barang',
            'required',
            array(
                'required' => 'Name tidak boleh kosong'
            )
        );
        $this->form_validation->set_rules(
            'resi',
            'Code resi',
            'required',
            array(
                'required' => 'Resi tidak boleh kosong'
            )
        );

        return $this->form_validation->run();
    }
}
