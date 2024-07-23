<?php

namespace app\modules;

use Yii;

class https_code
{
    const success_code = 200;
    const bad_request_code = 400;
    const notfound_code = 404;
    const error_code = 500;

    //payment
    const payment_cash = 1;
    const payment_paypal = 2;

    //status
    const status_pending = 1;
    const status_approved = 2;
    const status_rejected = 3;

    //Delete
    const status_not_delete = 0;
    const status_delete = 1;
}