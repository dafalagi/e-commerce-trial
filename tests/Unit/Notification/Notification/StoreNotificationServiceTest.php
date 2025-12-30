<?php

namespace Tests\Unit\Notification\Notification;

use App\Enums\Notification\NotificationType;
use App\Models\Auth\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreNotificationServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_store()
    {
        $user = User::factory()->create();

        $dto = [
            'user_uuid' => $user->uuid,
            'title' => 'New Notification',
            'message' => 'This is a test notification message.',
            'type' => NotificationType::INFO->value,
            'is_read' => false,
        ];

        $result = app('StoreNotificationService')->execute($dto);

        $this->assertEquals('Notification successfully stored.', $result['message']);
    }
}
