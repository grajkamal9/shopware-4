<?php
/**
 * Shopware 4.0
 * Copyright © 2013 shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace ShopwarePlugin\PaymentMethods\Components;

use Shopware\Models\Payment\PaymentInstance;

/**
 * Class GenericPaymentMethod
 * Used for all payment methods that require no specific logic
 *
 * @package ShopwarePlugin\PaymentMethods\Components
 */
class GenericPaymentMethod extends BasePaymentMethod
{
    /**
     * @inheritdoc
     */
    public function validate()
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    public function savePaymentData()
    {
        //nothing to do, no return expected
        return;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentPaymentData()
    {
        //nothing to do, array expected
        return array();
    }

    /**
     * @inheritdoc
     */
    public function createPaymentInstance($orderId, $userId, $paymentId)
    {
        $order = Shopware()->Models()->getRepository('Shopware\Models\Order\Order')->find($orderId);
        $user = Shopware()->Models()->getRepository('Shopware\Models\Customer\Customer')->find($userId);
        $paymentMean = Shopware()->Models()->getRepository('Shopware\Models\Payment\Payment')->find($paymentId);
        $addressData = $user->getBilling();

        $paymentInstance = new PaymentInstance();
        $paymentInstance->setOrder($order);
        $paymentInstance->setCustomer($user);
        $paymentInstance->setPaymentMean($paymentMean);

        $paymentInstance->setFirstName($addressData->getFirstName());
        $paymentInstance->setLastName($addressData->getLastName());
        $paymentInstance->setAddress($addressData->getStreet() . ' ' . $addressData->getStreetNumber());
        $paymentInstance->setZipCode($addressData->getZipCode());
        $paymentInstance->setCity($addressData->getCity());
        $paymentInstance->setAmount($order->getInvoiceAmount());

        Shopware()->Models()->persist($paymentInstance);
        Shopware()->Models()->flush();

        return $paymentInstance;
    }
}