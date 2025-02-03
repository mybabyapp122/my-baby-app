<?php
namespace api\controllers;

use common\libraries\CustomWidgets;
use common\models\Sale;
use common\models\Status;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class InvoiceController extends Controller {

    public function beforeAction($action) {
        $lang = Yii::$app->request->post('lang', 'ar');
        Yii::$app->language = $lang;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return 'At your service';
    }

    public function actionTaxInvoice($id, $returnHtmlContent = false)
    {
        if (isset($_GET['lang'])) {
            Yii::$app->language = $_GET['lang'];
        }

        Yii::$app->response->format = Response::FORMAT_HTML;

        /**
         * @var Sale $sale
         */
        $sale = Sale::find()
            ->where(['invoice_id' => $id])
            ->one();

        if (!isset($sale)) {
            return $this->render('invalid');
        }

        $inv = $sale->metadata['invoice'];
        $url = $sale->invoice_url;
        $items = $sale->metadata['items'];

//        $subtotal = $sale->getTotal($sale->invoice, false);
//        $total = $sale->getTotal($sale->invoice);
//        $vat = $sale->getVat();
//        $items = [];

        $items2 = [];
        foreach ($items as $item) {
            $item['total'] = $item['amount'] * $item['quantity'];
            $items2[] = $item;
        }
        $items = $items2;

        $data = [
            'company_name' => 'MyBaby',
            'company_address' => [
                '45th st',
                'Khobar',
                'Saudi Arabia',
            ],
            'company_email' => 'info@mybabyapp.net',
            'recipient_name' => $sale->payer['name'],
            'recipient_address' => [
                $sale->payer['mobile'],
            ],
            'invoice_id' => $sale->id,
            'invoice_date' => $sale->create_time,
            'payment_date' => $sale->status == 'paid' ? $sale->update_time : '',
            'items' => $items,
            'subtotal' => $inv['subtotal'],
            'vat' => $inv['vat'],
            'total' => $inv['total'],
            'invoice_url' => $url,
            'status' => Status::readStatus($sale->status),
            'lang' => $_GET['lang'] ?? 'ar',
        ];

//      // If $returnHtmlContent is true, return raw HTML
        if ($returnHtmlContent) {
            return $this->render('invoice-new', [
                'data' => $data,
            ]);
        }

        return $this->render('invoice', [
            'data' => $data,
        ]);
    }

}
