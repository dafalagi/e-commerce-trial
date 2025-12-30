<?php

namespace Tests\Unit\Notification\Notification;

use App\Models\Notification\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteNotificationServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_success_delete()
    {
        $notification = Notification::factory()->create();

        $dto = [
            'notification_uuid' => $notification->uuid,
            'version' => $notification->version,
        ];

        $result = app('DeleteNotificationService')->execute($dto);

        $this->assertEquals('Notification successfully deleted.', $result['message']);
    }
}
