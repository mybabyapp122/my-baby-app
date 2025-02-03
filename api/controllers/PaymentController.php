<?php
namespace api\controllers;

use api\modules\client\models\Login;
use common\libraries\CustomWidgets;
use common\libraries\Moyasar;
use common\models\Image;
use common\models\Sale;
use common\models\User;
use Yii;
use yii\base\Security;
use yii\rest\Controller;
use yii\base\DynamicModel;
use yii\web\Response;

class PaymentController extends Controller {
    public $modelClass = 'common\models\User';
    public $enableCsrfValidation = false; // Disable CSRF for API access


    //Should be accessible without login
    public function actionVerifyPayment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Retrieve and decode the JSON payload from POST data
        $payload = Yii::$app->request->post();

        if (isset($payload['id'], $payload['status'])) {
            $invoiceId = $payload['id'];
            $status = $payload['status'];

            // Find the sale by invoice ID
            $sale = Sale::findOne(['gateway_invoice_id' => $invoiceId]);

            if ($sale) {
                // Update the sale status based on the callback status
                if ($status === 'paid') {
                    $sale->status = 'paid';
                    $sale->status_ex = $payload['source']['message'] ?? '';
                    $sale->save(false); // Update without validation if fields are pre-validated

                    // Send confirmation email
//                    Yii::$app->mailer->compose('paymentSuccess', ['sale' => $sale])
//                        ->setTo($sale->payer_email) // Assuming payer email is stored in the sale table
//                        ->setSubject('Payment Successful')
//                        ->send();
                } elseif ($status === 'failed') {
                    $sale->status = 'cancelled';
                    $sale->status_ex = $payload['source']['message'] ?? '';
                    $sale->save(false);
                }

                // Return success response for confirmation
                return ['success' => true, 'message' => 'Sale status updated'];
            } else {
                return ['success' => false, 'message' => 'Sale not found'];
            }
        }

        return ['success' => false, 'message' => 'Invalid payload'];
    }

}
