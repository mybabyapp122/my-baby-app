<?php

namespace common\models;

use common\libraries\CustomWidgets;
use Yii;
use yii\web\Response;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string|null $model
 * @property int|null $model_id
 * @property int|null $sale_id
 * @property string|null $transaction_id
 * @property string|null $debit amount taken from
 * @property string|null $credit amount added to
 * @property string|null $description
 * @property float|null $base_amount
 * @property float|null $vat_amount
 * @property float|null $total_amount
 * @property float|null $vat_percent
 * @property string|null $currency
 * @property string|null $method cash, card, applepay, gpay, etc.
 * @property string|null $card_type mada, visa, mastercard, etc.
 * @property string|null $gateway moyasar, etc.
 * @property float|null $gateway_amount
 * @property float|null $gateway_cost
 * @property int|null $gateway_live
 * @property string|null $status
 * @property string|null $status_ex
 * @property string|null $payment_url
 * @property string|null $return_url
 * @property string|null $create_time
 * @property string|null $update_time
 *
 * @property Sale $sale
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id', 'sale_id', 'gateway_live'], 'integer'],
            [['base_amount', 'vat_amount', 'total_amount', 'vat_percent', 'gateway_amount', 'gateway_cost'], 'number'],
            [['status'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['model', 'transaction_id', 'debit', 'credit', 'method', 'card_type', 'gateway', 'status_ex', 'payment_url', 'return_url'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['currency'], 'string', 'max' => 32],
            [['sale_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sale::class, 'targetAttribute' => ['sale_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'sale_id' => Yii::t('app', 'Sale ID'),
            'transaction_id' => Yii::t('app', 'Transaction ID'),
            'debit' => Yii::t('app', 'Debit'),
            'credit' => Yii::t('app', 'Credit'),
            'description' => Yii::t('app', 'Description'),
            'base_amount' => Yii::t('app', 'Base Amount'),
            'vat_amount' => Yii::t('app', 'Vat Amount'),
            'total_amount' => Yii::t('app', 'Total Amount'),
            'vat_percent' => Yii::t('app', 'Vat Percent'),
            'currency' => Yii::t('app', 'Currency'),
            'method' => Yii::t('app', 'Method'),
            'card_type' => Yii::t('app', 'Card Type'),
            'gateway' => Yii::t('app', 'Gateway'),
            'gateway_amount' => Yii::t('app', 'Gateway Amount'),
            'gateway_cost' => Yii::t('app', 'Gateway Cost'),
            'gateway_live' => Yii::t('app', 'Gateway Live'),
            'status' => Yii::t('app', 'Status'),
            'status_ex' => Yii::t('app', 'Status Ex'),
            'payment_url' => Yii::t('app', 'Payment Url'),
            'return_url' => Yii::t('app', 'Return Url'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Gets query for [[Sale]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSale()
    {
        return $this->hasOne(Sale::class, ['id' => 'sale_id']);
    }

    //Create the transaction with status created then we'll create more from webhook
    public static function createTransaction($sale_id, $project = 'school', $credit = 'sale') {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $sale = Sale::findOne($sale_id);
        if (empty($sale)) {
            return CustomWidgets::returnFail(Yii::t('app', 'Sale not found'));
        }

        $transaction = new Transaction();
        $transaction->model = $project;
        $transaction->model_id = Yii::$app->user->id;
        $transaction->sale_id = $sale_id;
        $transaction->transaction_id = self::generateUniqueTransactionId(Yii::$app->user->id);
        $transaction->debit = 'bank';
        $transaction->credit = $credit;
        $transaction->base_amount = $sale->getTotal($sale->invoice);
        $transaction->total_amount = $sale->getTotal($sale->invoice);
        $transaction->gateway = 'moyasar';
        $transaction->status = 'created';
        $transaction->save(false);

        return $transaction;
    }

    public static function generateUniqueTransactionId($userId) {
        // Current Unix timestamp
        $timestamp = time();

        // Shorten the timestamp if necessary (though it's usually not too long)
        $shortTimestamp = substr($timestamp, -8); // Take last 8 digits of timestamp

        // Generate a shortened unique string with more entropy
        $uniqueString = substr(uniqid("", true), 0, 13); // Limit to 13 characters for safety

        // Additional random characters, using only numbers here to ensure the length is manageable
        $randomDigits = substr(mt_rand(10000, 99999), 0, 5); // 5 random digits

        // Concatenate parts with dashes for readability (optional)
        $transactionId = $shortTimestamp . '-' . $userId . '-' . $uniqueString . '-' . $randomDigits;

        // Ensure the total length does not exceed 255 characters
        if (strlen($transactionId) > 255) {
            $transactionId = substr($transactionId, 0, 255);
        }

        return $transactionId;
    }

}
