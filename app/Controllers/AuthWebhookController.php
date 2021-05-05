<?php

declare(strict_types=1);

namespace App\Controllers;

use CQ\Controllers\AuthWebhookController as CQAuthWebhookController;
use CQ\DB\DB;

final class AuthWebhookController extends CQAuthWebhookController
{
    /**
     * Delete user webhook app specific
     */
    protected function deleteSteps(string $userId): void
    { // TODO: delete from entries and users
        DB::delete(
            table: 'drinks',
            where: [
                'user_id' => $userId,
            ]
        );
    }
}
