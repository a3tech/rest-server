<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Mahasiswa extends CI_Controller{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct(){
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Mahasiswa_model', 'mhs');
        $this->methods['index_get']['limit'] = 100;
        $this->methods['index_delete']['limit'] = 100;
        $this->methods['index_post']['limit'] = 100;
        $this->methods['index_put']['limit'] = 100;
	}


 public function index_get(){

    $id = $this->get('id');
    if($id === null){ 
        $mahasiswa = $this->mhs->getMahasiswa();
    }else{
        $mahasiswa = $this->mhs->getMahasiswa($id);
    }

     if($mahasiswa){
        $this->response([
            'status' => true,
            'data' => $mahasiswa
        ], 200);
     }else{
        $this->response([
            'status' => false,
            'message' => 'ID Not Found'
        ], 404);
     }
 }   

 public function index_delete(){
    $id = $this->delete('id');
    if($id === null){ 
        $this->response([
            'status' => false,
            'message' => 'Masukan ID !'
        ], 404);
    }else{
        if($this->mhs->deleteMahasiswa($id)>0){
            $this->response([
                'status' => true,
                'id' => $id,
                'message'=>'hapus berhasil !'
            ], 200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'ID Not Found'
            ], 404);
        }
    }
}

public function index_post(){
$data = [
    'nrp' =>$this->post('nrp'),
    'nama' =>$this->post('nama'),
    'email' =>$this->post('email'),
    'jurusan' =>$this->post('jurusan')
];
if($this->mhs->createMahasiswa($data)>0){
    $this->response([
        'status' => true,
        'message'=>'data berhasil ditambah !'
    ], 200);
}else{
    $this->response([
        'status' => false,
        'message' => 'Data Gagal Ditambahkan !'
    ], 404);
}
}


public function index_put(){
    $id = $this->put('id');
    $data = [
        'nrp' =>$this->put('nrp'),
        'nama' =>$this->put('nama'),
        'email' =>$this->put('email'),
        'jurusan' =>$this->put('jurusan')
    ];
    if($this->mhs->updateMahasiswa($data,$id)>0){
        $this->response([
            'status' => true,
            'message'=>'data berhasil diubah !'
        ], 200);
    }else{
        $this->response([
            'status' => false,
            'message' => 'Data Gagal Diubah !'
        ], 404);
    }
    }




}