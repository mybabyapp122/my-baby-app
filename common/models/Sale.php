<?php

namespace common\models;

use common\libraries\CustomWidgets;
use Yii;

/**
 * This is the model class for table "sale".
 *
 * @property int $id
 * @property string|null $creator_model
 * @property int|null $creator_id
 * @property string|null $payer_model
 * @property int|null $payer_id
 * @property string|null $type sale, plan-upgrade, etc.
 * @property string|null $status
 * @property string|null $status_ex
 * @property string|null $invoice_id
 * @property string|null $metadata
 * @property string|null $order_date
 * @property string|null $due_date
 * @property string|null $gateway_invoice_id
 * @property string|null $gateway_invoice_url
 * @property string|null $create_time
 * @property string|null $update_time
 *
 * @property Transaction[] $transactions
 *
 * @property string $invoice_url
 * @property array $creator
 * @property array $payer
 *
 * metadata json format:
 * items: [[name, quantity, amount]]
 * invoice: [subtotal, discount (if any), vat, total]
 */
class Sale extends \yii\db\ActiveRecord
{
    public array $metadataTemp;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creator_id', 'payer_id'], 'integer'],
            [['status'], 'string'],
            [['metadata', 'order_date', 'due_date', 'create_time', 'update_time'], 'safe'],
            [['creator_model', 'payer_model'], 'string', 'max' => 50],
            [['type', 'status_ex', 'invoice_id'], 'string', 'max' => 255],
            [['gateway_invoice_id', 'gateway_invoice_url'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'creator_model' => Yii::t('app', 'Creator Model'),
            'creator_id' => Yii::t('app', 'Creator ID'),
            'payer_model' => Yii::t('app', 'Payer Model'),
            'payer_id' => Yii::t('app', 'Payer ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'status_ex' => Yii::t('app', 'Status Ex'),
            'invoice_id' => Yii::t('app', 'Invoice ID'),
            'metadata' => Yii::t('app', 'Metadata'),
            'order_date' => Yii::t('app', 'Order Date'),
            'due_date' => Yii::t('app', 'Due Date'),
            'gateway_invoice_id' => Yii::t('app', 'Gateway Invoice ID'),
            'gateway_invoice_url' => Yii::t('app', 'Gateway Invoice Url'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, ['sale_id' => 'id']);
    }

    public function getCreator() {
        switch ($this->creator_model) {
            case 'school';
                $user = User::findOne($this->creator_id);
                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                ];
                break;
            default:
                $data = [
                    'name' => 'MyBaby',
                    'email' => 'info@mybaby.com',
                    'mobile' => '',
                ];
        }

        return $data;
    }

    public function getPayer() {
        switch ($this->payer_model) {
            case 'school';
            case 'parent';
                $user = User::findOne($this->payer_id);
                $data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                ];
                break;
            default:
                $data = [
                    'name' => '',
                    'email' => '',
                    'mobile' => '',
                ];
        }

        return $data;
    }

    /**
     * @param $items
     * @return array
     * it formats the input data in correct format)
     */
    private function verifyItems() {
        $md = $this->metadata ?? $this->metadataTemp;
        $result = [];
        foreach ($md['items'] as $item) {
            $object = [
                'title' => $item['title'] ?? 'Description',
                'quantity' => $item['quantity'] ?? 1,
                'amount' => $item['amount'] ?? 0,
            ];

            $result[] = $object;
        }
        return $result;
    }

    //sums up amount of all items
    //doesn't include vat and discounts (if any)
    private function subtotal() {
        $md = $this->metadata ?? $this->metadataTemp;
        $total = 0;
        foreach ($md['items'] as $item) {
            $total += $item['amount'] * $item['quantity'];
        }
        return $total;
    }

    private function vat($total) {
        $vatPercent = 15;
        $vat = ($total * $vatPercent) / 100;
        return $vat;
    }

    public function invoiceJson() {
        $st = $this->subtotal();
        $vt = $this->vat($st);
        $to = $st + $vt;

        return [
            'subtotal' => $st,
            'vat' => $vt,
            'total' => $to,
        ];
    }

    public static function getAllPaidInvoicesGeneratedBySystem() {
        $sales = Sale::find()
            ->where(['creator_model' => 'mybaby'])
            ->andWhere(['status' => 'paid'])
            ->all();

        $amount = 0;

        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $amount += $sale->invoiceJson()['total'];
            }
        }

        return $amount;
    }

    public static function getAllUnPaidInvoicesGeneratedBySystem() {
        $sales = Sale::find()
            ->where(['creator_model' => 'mybaby'])
            ->andWhere(['status' => 'unpaid'])
            ->all();

        $amount = 0;

        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $amount += $sale->invoiceJson()['total'];
            }
        }

        return $amount;
    }

    public static function getAllPaidSales() {
        $sales = Sale::find()
            ->where(['payer_model' => 'parent'])
            ->andWhere(['creator_id' => Yii::$app->user->id])
            ->andWhere(['status' => 'paid'])
            ->all();

        $amount = 0;

        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $amount += $sale->invoiceJson()['total'];
            }
        }

        return $amount;
    }

    public static function getAllUnpaidSales() {
        $sales = Sale::find()
            ->where(['payer_model' => 'parent'])
            ->andWhere(['creator_id' => Yii::$app->user->id])
            ->andWhere(['status' => 'unpaid'])
            ->all();

        $amount = 0;

        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $amount += $sale->invoiceJson()['total'];
            }
        }

        return $amount;
    }

    public static function getOverdueSales() {
        $sales = Sale::find()
            ->where(['creator_model' => 'school'])
            ->andWhere(['creator_id' => Yii::$app->user->id])
            ->andWhere(['status' => 'unpaid'])
            ->andWhere(['<=', 'due_date', date('Y-m-d H:i:s')]) // Due date is in the past or now
            ->all();

        $amount = 0;

        if (!empty($sales)) {
            foreach ($sales as $sale) {
                $amount += $sale->invoiceJson()['total'];
            }
        }

        return $amount;
    }

    public static function newSale($creatorModel, $creatorId, $payerModel, $payerId, $items, $type, $additionalMetadata = null) {
        $sale = new Sale();
        $sale->creator_model = $creatorModel;
        $sale->creator_id = $creatorId;
        $sale->payer_model = $payerModel;
        $sale->payer_id = $payerId;
        $sale->invoice_id = CustomWidgets::generateRandomCode();
        $sale->type = $type;

        //initializing local variable
        $sale->metadataTemp = [];

        //Add additional metadata which will not be calculated for invoicing
        if (!empty($additionalMetadata)) {
            $sale->metadataTemp['metadata'] = $additionalMetadata;
            $sale->due_date = $additionalMetadata['invoice_start'] ?? NULL;
        }

        //populating unverified items data to local variable
        $sale->metadataTemp['items'] = $items;

        //verifying items and updating local variable
        $sale->metadataTemp['items'] = $sale->verifyItems();

        //populating invoice items to local variable
        $sale->metadataTemp['invoice'] = $sale->invoiceJson();

        //pushing local variable to sale column "metadata"
        $sale->metadata = $sale->metadataTemp;

        $exists = $sale->unpaidSaleExists(); //For now returns always true. Not checking exists or not.
        if (!$exists['success']) {
            return CustomWidgets::returnFail('An unpaid invoice with the same schedule already exists. Please either pay or cancel the existing unpaid invoice.', $exists['data']);
        }
        if (!$sale->save()) {
            return CustomWidgets::returnFail('an error occurred', $sale->getErrors());
        }

        return CustomWidgets::returnSuccess([
            'id' => $sale->id,
            'invoice_url' => $sale->invoice_url
        ], 'Sale generated!');
    }

    public static function getBillingCycles($start_date, $end_date) {
        $start_date = new \DateTime($start_date);
        $end_date = new \DateTime($end_date);

        $cycles = [];
        $cycleStart = clone $start_date;

        while ($cycleStart <= $end_date) {
            // Calculate the end of the cycle: 28th of the current or next month
            $cycleEnd = clone $cycleStart;
            if ($cycleStart->format('d') <= 28) {
                $cycleEnd->setDate((int) $cycleStart->format('Y'), (int) $cycleStart->format('m'), 28);
            } else {
                $cycleEnd->modify('last day of next month')->setDate((int) $cycleEnd->format('Y'), (int) $cycleEnd->format('m'), 28);
            }

            // Ensure cycleEnd does not exceed the user's plan end date
            if ($cycleEnd > $end_date) {
                $cycleEnd = clone $end_date;
            }

            // Add the cycle to the array
            $cycles[] = [
                'start_date' => $cycleStart->format('Y-m-d'),
                'end_date' => $cycleEnd->format('Y-m-d'),
            ];

            // Move to the next cycle
            $cycleStart = clone $cycleEnd;
            $cycleStart->modify('+1 day');
        }

        return $cycles;
    }

    public static function processBillingCyclesold($metadata)
    {
        $student_id = $metadata['student_id'] ?? 0;
        $student = Student::findOne($student_id);
        if (!$student) {
            throw new \Exception("Student with ID {$metadata['student_id']} not found.");
        }


        $billingCycles = self::getBillingCycles($metadata['starting_date'], $metadata['ending_date']);

        if (empty($billingCycles)) {
            return CustomWidgets::returnFail('Failed to generate billing cycles');
        }

        foreach ($billingCycles as $cycle) {
            if (isset($cycle['start_date'], $cycle['end_date'])) {
                $cycleStart = new \DateTime($cycle['start_date']);
                $cycleEnd = new \DateTime($cycle['end_date']);

                // Calculate hours for this cycle
                $schedule = Student::scheduleDetails(
                    $student->id,
                    $cycleStart->format('Y-m-d'),
                    $cycleEnd->format('Y-m-d')
                );

                // Calculate invoice total
                $perHourRate = $metadata['per_hour_rate'] ?? 0;
                $invoiceTotal = $schedule['hours'] * $perHourRate;

                // Prepare items and metadata for the new sale
                $items = [
                    [
                        'title' => 'Fee - ' . $cycleStart->format('M d, Y') . ' to ' . $cycleEnd->format('M d, Y'), // e.g., "Monthly Fee - November 2024"
                        'amount' => $invoiceTotal,
                        'quantity' => 1,
                    ],
                ];

                $additionalMetadata = [
                    'student_id' => $student->id,
                    'starting_date' => $metadata['starting_date'],
                    'ending_date' => $metadata['ending_date'],
                    'invoice_hours' => $schedule['hours'],
                    'invoice_total' => $invoiceTotal,
                    'invoice_start' => $cycleStart->format('Y-m-d'),
                    'invoice_end' => $cycleEnd->format('Y-m-d'),
                ];

                // Create the new sale
                self::newSale(
                    'school',
                    Yii::$app->user->id,
                    'parent',
                    $student->parent_id,
                    $items,
                    'fee',
                    $additionalMetadata
                );
            }
        }

        return CustomWidgets::returnSuccess([], 'All Invoices Generated');
    }

    public static function processBillingCycles($metadata)
    {
        $student_id = $metadata['student_id'] ?? 0;
        $student = Student::findOne($student_id);

        if (!$student) {
            throw new \Exception("Student with ID {$metadata['student_id']} not found.");
        }

        $pricingModel = $metadata['pricing_model'] ?? 'hourly'; // Get pricing model
        $rate = $metadata['per_hour_rate'] ?? 0;
        $totalUnits = $metadata['total_hours'] ?? 0; // Could be hours, months, semesters, or years
        $start_date = new \DateTime($metadata['starting_date']);
        $end_date = new \DateTime($metadata['ending_date']);

        // Define billing cycles based on the pricing model
        $billingCycles = [];

        if ($pricingModel === 'monthly') {
            for ($i = 0; $i < $totalUnits; $i++) {
                $cycleStart = clone $start_date;
                $cycleStart->modify("+$i months");
                $cycleEnd = (clone $cycleStart)->modify('last day of this month');

                // Ensure cycle does not exceed ending date
                if ($cycleEnd > $end_date) {
                    $cycleEnd = clone $end_date;
                }

                $billingCycles[] = [
                    'start_date' => $cycleStart->format('Y-m-d'),
                    'end_date' => $cycleEnd->format('Y-m-d'),
                ];
            }
        } elseif ($pricingModel === 'semester') {
            for ($i = 0; $i < $totalUnits; $i++) {
                $cycleStart = clone $start_date;
                $cycleStart->modify("+".($i * 6)." months"); // Each semester is 6 months
                $cycleEnd = (clone $cycleStart)->modify('+5 months')->modify('last day of this month');

                // Ensure cycle does not exceed ending date
                if ($cycleEnd > $end_date) {
                    $cycleEnd = clone $end_date;
                }

                $billingCycles[] = [
                    'start_date' => $cycleStart->format('Y-m-d'),
                    'end_date' => $cycleEnd->format('Y-m-d'),
                ];
            }
        } elseif ($pricingModel === 'yearly') {
            for ($i = 0; $i < $totalUnits; $i++) {
                $cycleStart = clone $start_date;
                $cycleStart->modify("+$i years");
                $cycleEnd = (clone $cycleStart)->modify('+11 months')->modify('last day of this month');

                // Ensure cycle does not exceed ending date
                if ($cycleEnd > $end_date) {
                    $cycleEnd = clone $end_date;
                }

                $billingCycles[] = [
                    'start_date' => $cycleStart->format('Y-m-d'),
                    'end_date' => $cycleEnd->format('Y-m-d'),
                ];
            }
        } else {
            // Default to hourly logic if no valid model is found
            $billingCycles = self::getBillingCycles($metadata['starting_date'], $metadata['ending_date']);
        }

        if (empty($billingCycles)) {
            return CustomWidgets::returnFail('Failed to generate billing cycles');
        }

        foreach ($billingCycles as $cycle) {
            if (isset($cycle['start_date'], $cycle['end_date'])) {
                $cycleStart = new \DateTime($cycle['start_date']);
                $cycleEnd = new \DateTime($cycle['end_date']);

                // Calculate invoice total based on pricing model
                $invoiceTotal = 0;
                if ($pricingModel === 'hourly') {
                    $schedule = Student::scheduleDetails(
                        $student->id,
                        $cycleStart->format('Y-m-d'),
                        $cycleEnd->format('Y-m-d')
                    );
                    $perHourRate = $metadata['per_hour_rate'] ?? 0;
                    $invoiceTotal = $schedule['hours'] * $perHourRate;
                } else {
                    $invoiceTotal = $metadata['total_amount'] / count($billingCycles); // Divide total amount equally for monthly, semester, yearly
                }

                // Prepare invoice items
                $items = [
                    [
                        'title' => ucfirst($pricingModel) . ' Fee - ' . $cycleStart->format('M d, Y') . ' to ' . $cycleEnd->format('M d, Y'),
                        'amount' => $invoiceTotal,
                        'quantity' => 1,
                    ],
                ];

                $additionalMetadata = [
                    'student_id' => $student->id,
                    'pricing_model' => $metadata['pricing_model'],
                    'starting_date' => $metadata['starting_date'],
                    'ending_date' => $metadata['ending_date'],
                    'invoice_total' => $invoiceTotal,
                    'invoice_start' => $cycleStart->format('Y-m-d'),
                    'invoice_end' => $cycleEnd->format('Y-m-d'),
                ];

                // Create invoice record
                self::newSale(
                    'school',
                    Yii::$app->user->id,
                    'parent',
                    $student->parent_id,
                    $items,
                    'fee',
                    $additionalMetadata
                );
            }
        }

        return CustomWidgets::returnSuccess([], 'All Invoices Generated');
    }

//    public static function processBillingCyclesOld($sale_id = null, $saleDetails = null)
//    {
//
//        // Not sure what would happen if student's schedule is changed.
//        //What if student finished his schedule then started coming again after 1 month?
//        //SOLUTION::
//        //What if we create all the invoices for his full term but send him notification only when its due
//        //this way we don't have to bother if the schedule was changed or not, in case of schedule change either we remove all his pending invoices
//        //OR we ask the school to cancel previous invoices manually
//        //If we go with this method we dont have to store next_payment_due in student table, or even if we store it doesn't matter much.
//
//        $metadata = [];
//        if ($sale_id) {
//            // Fetch the existing sale if sale_id is provided
//            $sale = Sale::find()
//                ->where(['id' => $sale_id])
//                ->orderBy(['update_time' => SORT_DESC])
//                ->one();
//
//            if (!$sale) {
//                throw new \Exception("Sale with ID {$sale_id} not found.");
//            }
//
//            // Decode metadata JSON
//            $metadata = is_array($sale->metadata) ? $sale->metadata : json_decode($sale->metadata, true);
//
//        } elseif ($saleDetails) {
//            // Fetch the student and check if payment_due_date or last_sale_id is null
//            $student = Student::findOne($saleDetails['student_id']);
//
//            if (!$student) {
//                throw new \Exception("Student with ID {$saleDetails['student_id']} not found.");
//            }
//
//            $sale = new Sale();
//            $sale->creator_model = 'school';
//            $sale->creator_id = Yii::$app->user->id;
//            $sale->payer_model = 'parent';
//            $sale->payer_id = $student->parent_id;
//            $sale->type = 'fee';
//            $sale->status = 'unpaid';
//
//            $metadata['metadata'] = $saleDetails;
//        }
//
//        // Check if metadata and nested 'metadata' keys exist and have starting_date and ending_date
//        if (
//            isset($metadata['metadata']['starting_date'], $metadata['metadata']['ending_date'])
//        ) {
//            $startingDate = new \DateTime($metadata['metadata']['starting_date']);
//            $endingDate = new \DateTime($metadata['metadata']['ending_date']);
//
//            // Get the last invoice_end date from the metadata if available
//            $student = isset($metadata['metadata']['student_id']) ?? 0;
//            $student = Student::find()->where(['id' => $student])->one();
//            if ($student) {
//                $lastInvoiceEnd = new \DateTime($student->payment_due_date ?? $metadata['metadata']['starting_date']);
//            }
//
//            // Ensure the next cycle starts after the last invoice_end
//            $cycleStart = clone $lastInvoiceEnd;
//            $cycleStart->modify('+0 day');
//
//
//            if ($cycleStart >= $endingDate) {
//                return CustomWidgets::returnFail('Student schedule has finished. Cannot generate more invoices');
//            }
//
//            // Calculate the cycle end date
//            $cycleEnd = clone $cycleStart;
//            $cycleEnd->modify('+27 days'); // End on the 28th day
//            if ($cycleEnd > $endingDate) {
//                $cycleEnd = clone $endingDate; // Stop at ending_date if it's before the full cycle
//            }
//
//            // Calculate hours for this cycle
//            $schedule = Student::scheduleDetails(
//                $metadata['metadata']['student_id'],
//                $cycleStart->format('Y-m-d'),
//                $cycleEnd->format('Y-m-d')
//            );
//
//            // Calculate invoice total
//            $perHourRate = $metadata['metadata']['per_hour_rate'] ?? 0;
//            $invoiceTotal = $schedule['hours'] * $perHourRate;
//
//            //To get the next months due date
//            $nextCycleEnd = clone $cycleEnd;
//            $nextCycleEnd->modify('+27 days'); // End on the 28th day
//            if ($nextCycleEnd > $endingDate) {
//                $nextCycleEnd = clone $endingDate; // Stop at ending_date if it's before the full cycle
//            }
//
//            // Prepare items and metadata for the new sale
//            $items = [
//                [
//                    'title' => 'Monthly Fee - ' . $cycleEnd->format('F Y'), // e.g., "Monthly Fee - November 2024"
//                    'amount' => $invoiceTotal,
//                    'quantity' => 1,
//                ],
//            ];
//
//            $additionalMetadata = [
//                'student_id' => $metadata['metadata']['student_id'],
//                'starting_date' => $metadata['metadata']['starting_date'],
//                'ending_date' => $metadata['metadata']['ending_date'],
//
////                    'invoice_hours' => $schedule['hours'],
////                    'invoice_total' => $invoiceTotal,
//                'invoice_start' => $cycleStart->format('Y-m-d'),
//                'invoice_end' => $cycleEnd->format('Y-m-d'),
//                'next_due_date' => $nextCycleEnd->format('Y-m-d'),
//            ];
//
//
//            // Create the new sale
//            return self::newSale(
//                $sale->creator_model,
//                $sale->creator_id,
//                $sale->payer_model,
//                $sale->payer_id,
//                $items,
//                $sale->type,
//                $additionalMetadata
//            );
//        }
//    }


    public function getInvoice_url() {
        if (empty($this->invoice_id)) {
            return '';
        }

        return CustomWidgets::apiUrl() . '/invoice/tax-invoice?id=' . $this->invoice_id . '&lang=' . Yii::$app->language;
    }

    /**
     * Check the payment status and set the sale status accordingly.
     *
     * @return void
     */
    public function checkPaymentAndSetStatus($new_status = 'unpaid')
    {
        // Get all transactions related to this sale
        $transactions = $this->getTransactions()->all();

        $totalPaid = 0;
        $totalRefunded = 0;

        // Iterate through each transaction
        foreach ($transactions as $transaction) {
            if ($transaction->status == 'paid') {
                $totalPaid += $transaction->gateway_amount;
            } elseif ($transaction->status == 'refunded') {
                $totalRefunded += $transaction->gateway_amount;
            }
        }

        // Calculate the net paid amount
        $netPaid = $totalPaid - $totalRefunded;

        // Get the total amount from the invoice
        $invoiceTotal = $this->invoiceJson()['total'];

        // Update the sale status based on the payment amount
        if ($netPaid >= $invoiceTotal) {
            $this->status = 'paid';

            //do sale related actions here
            //e.g. plan upgrade, etc.

        } else {
            $this->status = $new_status;
        }

        // Save the changes to the sale
        $this->save(false);
    }



    /**
     * Checks if the sale record can be saved.
     *
     */
    public function unpaidSaleExists()
    {
        //TODO : Allow school to create as many as they want. they can always go to payments section and manually cancel
        return CustomWidgets::returnSuccess([], 'No existing invoices');

        // Parse the metadata JSON
        $metadata = is_array($this->metadata) ? $this->metadata : json_decode($this->metadata, true);
        $metadata = $metadata['metadata'];

        if (isset($metadata['starting_date'], $metadata['ending_date'])) {
            // Check for existing unpaid invoices with the same payer and type
            $existingInvoice = Sale::find()
                ->where([
                    'creator_model' => $this->creator_model,
                    'creator_id' => $this->creator_id,
                    'payer_model' => $this->payer_model,
                    'payer_id' => $this->payer_id,
                    'type' => $this->type,
                    'status' => 'unpaid',
                ])
                ->andWhere([
                    'JSON_EXTRACT(metadata, "$.metadata.starting_date")' => $metadata['starting_date'],
                    'JSON_EXTRACT(metadata, "$.metadata.ending_date")' => $metadata['ending_date'],
                ])
                ->one();

            if ($existingInvoice) {
                // Return error message if an unpaid invoice exists
                return CustomWidgets::returnFail('Already Exists', $existingInvoice);
//                return 'An unpaid invoice with the same schedule already exists. Please either pay or cancel the existing unpaid invoice.';
            }
        }
        return CustomWidgets::returnSuccess([], 'No existing invoices');
//        return true; // Validation passed
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        if (array_key_exists('status', $changedAttributes)) {
            //Status was changed
            $this->handleAfterPayment();
//            if ($changedAttributes['status'] == 'unpaid' && $this->status == 'paid') {
//            }
        }
    }

    /**
     * @return array|void
     */
    function handleAfterPayment() {

        switch ($this->status) {
            case 'paid':
                //status of sale was changed to paid

                //Sale type is plan-upgrade then upgrade the plan
                if ($this->type == 'plan-upgrade') {
                    // Parse the metadata JSON
                    $metadata = is_array($this->metadata) ? $this->metadata : json_decode($this->metadata, true);
                    $metadata = $metadata['metadata'];
                    $current_plan = $metadata['current_plan_id'];
                    $new_plan = $metadata['new_plan_id'];
                    $school = User::find()->where(['id' => $this->payer_id])->one();
                    $school->applyPlan($new_plan);
                    $school->sendSchoolPlanUpgradeEmail( ($current_plan ==  $new_plan) );
                }

                //Send Payer email and push notification
                $payer = User::find()->where(['id' => $this->payer_id])->one();
                $payer->sendInvoiceNotification($this->invoice_id);

                break;
            case 'failed':
                break;
            case 'unpaid':
            case 'cancelled':
            default:
                $mesg = '';
        }

        if ($this->status != 'paid') {
            return CustomWidgets::returnFail('sale not paid');
        }
    }


    function toJson() {
        $data = $this->toArray(['id', 'type', 'status', 'invoice_id', 'metadata', 'create_time']);
        $data['creator'] = $this->creator;
        $data['payer'] = $this->payer;
        $data['invoice_url'] = $this->invoice_url;
        return $data;
    }

}
