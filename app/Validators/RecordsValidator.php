<?php

declare(strict_types=1);

namespace App\Validators;

use CQ\Validators\Validator;
use Respect\Validation\Validator as v;

final class RecordsValidator extends Validator
{
    /**
     * Validate json submission.
     */
    public static function create(object $data): void
    {
        $v = v::attribute('type', v::oneOf(
            v::equals('water'),
            v::equals('bier'),
            v::equals('shot'),
            v::equals('barf')
        ));

        self::validate($v, $data);
    }
}
