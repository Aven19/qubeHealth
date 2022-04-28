<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use CodeIgniter\Controller;

class DocumentController extends Controller
{
    public function upload()
    {  
        $session = session();
        helper(['form', 'url']);
         
        $database = \Config\Database::connect();
        $builder = $database->table('documents');

        $imageFile = $this->request->getFile('file');
     
        $validateImage = $this->validate([
            'file' => 'uploaded[file]|max_size[file,1024]|mime_in[file,image/png,image/jpg,image/jpeg,image/gif]',
        ]);

        $response = [
            'success' => false,
            'data' => '',
            'msg' => "File could not upload"
        ];
        if ($validateImage) {
            $imageFile = $this->request->getFile('file');

            $imageFile->move(WRITEPATH . 'uploads');

            $data = [
                'user_id' => $session->get('id'),
                'img_name' => $imageFile->getClientName(),
                'file'  => $imageFile->getClientMimeType(),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $save = $builder->insert($data);

            $response = [
                'success' => true,
                'data' => $save,
                'msg' => "Image successfully uploaded"
            ];
        }
        return $this->response->setJSON($response);
    }

    public function getDocs($id)
    {
        $table = new \CodeIgniter\View\Table();

        $template = array(
            'table_open' => '<table border="1" class="table" cellpadding="2" cellspacing="1">',
        );

        $table->setTemplate($template);

        $table->setHeading("User's Name", "Phone Number", "documents");

        $model = new DocumentModel();

        $docs = $model->getUsersByDocuments($id);

        foreach ($docs as $doc) :
            $table->addRow($doc->phone, $doc->name, "<img class='mb-3' id='' alt='Preview Image' src='".base_url('/writable/uploads/'.$doc->img_name)."' />");
        endforeach;

        $html = $table->generate();

        $data['table'] = $html;

        return view('userDocuments', $data);

    }
    
}
