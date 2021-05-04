<?php

declare(strict_types=1);

namespace App\Validators;

use CQ\Validators\Validator;
use Respect\Validation\Validator as v;

final class DrinksValidator extends Validator
{
    /**
     * Validate json submission.
     */
    public static function create(object $data): void
    {
        $v = v::attribute('type', v::oneOf(
            v::equals('Water'),
            v::equals('Bier'),
            v::equals('Shot'),
            v::equals('Barf')
        ));

        self::validate($v, $data);
    }
}
