<?php

use yii\db\Migration;

/**
 * Class m241104_141711_create_sales_tables
 */
class m241104_141711_create_sales_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
-- Create syntax for TABLE 'sale'
CREATE TABLE `sale` (
  `id` int NOT NULL AUTO_INCREMENT,
  `creator_model` varchar(50) DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `payer_model` varchar(50) DEFAULT NULL,
  `payer_id` int DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'sale, plan-upgrade, etc.',
  `status` enum('paid','unpaid') DEFAULT 'unpaid',
  `status_ex` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=800000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create syntax for TABLE 'transaction'
CREATE TABLE `transaction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int DEFAULT NULL,
  `sale_id` int DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `debit` varchar(255) DEFAULT NULL COMMENT 'amount taken from',
  `credit` varchar(255) DEFAULT NULL COMMENT 'amount added to',
  `description` varchar(500) DEFAULT NULL,
  `base_amount` decimal(19,4) DEFAULT NULL,
  `vat_amount` decimal(19,4) DEFAULT '0.0000',
  `total_amount` decimal(19,4) DEFAULT '0.0000',
  `vat_percent` decimal(19,4) DEFAULT NULL,
  `currency` varchar(32) DEFAULT 'SAR',
  `method` varchar(255) DEFAULT NULL COMMENT 'cash, card, applepay, gpay, etc.',
  `card_type` varchar(255) DEFAULT NULL COMMENT 'mada, visa, mastercard, etc.',
  `gateway` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'moyasar, etc.',
  `gateway_amount` decimal(19,2) DEFAULT '0.00',
  `gateway_cost` decimal(19,2) DEFAULT '0.00',
  `gateway_live` tinyint(1) DEFAULT '1',
  `status` enum('created','initiated','paid','cancelled','refunded','failed','unknown') DEFAULT 'created',
  `status_ex` varchar(255) DEFAULT NULL,
  `payment_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `return_url` varchar(255) DEFAULT NULL,
  `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `update_time` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=400000 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241104_141711_create_sales_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241104_141711_create_sales_tables cannot be reverted.\n";

        return false;
    }
    */
}
