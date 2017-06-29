<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 20.6.2017 г.
 * Time: 15:10 ч.
 */

namespace Omniship;

class Consts
{

    //Option Before Payment
    const OPTION_BEFORE_PAYMENT_OPEN = 'open';
    const OPTION_BEFORE_PAYMENT_TEST = 'test';

    //payer type
    const PAYER_SENDER = 'SENDER';
    const PAYER_RECEIVER = 'RECEIVER';
    const PAYER_OTHER = 'OTHER';

    //payment types
    const PAYMENT_CASH = 'CASH';
    const PAYMENT_CREDIT = 'CREDIT';
    const PAYMENT_BONUS = 'BONUS';
    const PAYMENT_VOUCHER = 'VOUCHER';
    const PAYMENT_FREE = 'FREE';

    //services
    const SERVICE_ALLOWED = 'ALLOWED';
    const SERVICE_BANNED = 'BANNED';
    const SERVICE_REQUIRED = 'REQUIRED';
    const SERVICE_NULL = 'NULL';

    //office types
    const OFFICE_TYPE_OFFICE = 'office';
    const OFFICE_TYPE_APT = 'apt';

}