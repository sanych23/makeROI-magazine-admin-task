<?php
//declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Attributes\Description;
use BenSampo\Enum\Enum;

/**
 * @method static static REGISTRATION()
 * @method static static DELIVERY()
 * @method static static SUCCESS()
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
class OrderStatusType extends Enum
{
//    const REGISTRATION = "Заказ собирается пользователем";
//    const DELIVERY = "Заказ оплачен и отправлен пользователю";
//    const SUCCESS = "Заказ успешно завершен";

    #[Description('Пользователь еще заполняет корзину заказа')]
    const REGISTRATION = "REGISTRATION";

    #[Description('Пользователь оплатил заказ')]
    const DELIVERY = "DELIVERY";

    #[Description('Заказ выполнен успешно')]
    const SUCCESS = "SUCCESS";

}
