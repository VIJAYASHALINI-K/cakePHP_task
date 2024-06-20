<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Utility\Xml;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
class PdfController extends AppController
{
    // Log::debug('inside controller');
    public function display()

    {
        
        // $this->viewBuilder()->enableAutoLayout(false);
        $pdf_data=Xml::toArray(Xml::build($this->request->input()));
        $pdf_table = TableRegistry::getTableLocator()->get('UsersData');
        $pdf = $pdf_table->newEntity($pdf_data['user']); 
        $user_name =  $pdf_data['user']['user_name'];                   
        $email = $pdf_data['user']['email'];
        $hashPswdObj = new DefaultPasswordHasher;
        $password = $hashPswdObj->hash($pdf_data['user']['password']);
        $address_line_1 = $pdf_data['user']['address_line_1'];
        $address_line_2 = $pdf_data['user']['address_line_2'];
        $pincode = $pdf_data['user']['pincode'];
        $phone_number = $pdf_data['user']['phone_number'];
        $this->set(compact('user_name','email','password','address_line_1','address_line_2','pincode','phone_number'));
        $this->render('print');
        // App::import('Vendor', 'HTML2PDF', array('file' => 'html2pdf'.DS.'html2pdf.class.php'));

        // $html2pdf = new HTML2PDF('P','A4','en');
        // $html2pdf->WriteHTML($content);
        // $html2pdf->Output('file1.pdf');
    }
    // public function viewClasses(): array
    // {
    //     return $this->viewClasses[] = Pdfiew::class;
    // }
}
