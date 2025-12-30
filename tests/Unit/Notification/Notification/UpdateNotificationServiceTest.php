<?php

namespace Tests\Unit\Notification\Notification;

use App\Enums\Notification\NotificationType;
use App\Models\Auth\User;
use App\Models\Notification\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UpdateNotificationServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_update()
    {
        $notification = Notification::factory()->create();
        $user = User::factory()->create();

        $dto = [
            'notification_uuid' => $notification->uuid,
            'user_uuid' => $user->uuid,
            'title' => 'Updated Notification Title',
            'message' => 'This is an updated test notification message.',
            'type' => NotificationType::WARNING->value,
            'is_read' => true,
            'version' => $notification->version,
        ];

        $result = app('UpdateNotificationService')->execute($dto);

        $this->assertEquals('Notification successfully updated.', $result['message']);
    }
}
