<?php 

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index() {
        
        $model = new UserModel();
        $user = $model -> findAll();

        // return $this->response->setJSON([
        //     'user' => $user ->getEMail()
        // ]);

        foreach ($user as $user) {
            echo $user->getCreatedAt();
            echo "<br>";
        }
    }
}
