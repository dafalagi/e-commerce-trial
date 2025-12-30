<?php

namespace App\Services\Notification\Notification;

use App\Enums\Notification\NotificationType;
use App\Models\Auth\User;
use App\Models\Notification\Notification;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;
use Illuminate\Validation\Rule;

class StoreNotificationService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = new Notification;

        $model->user_id = $dto['user_id'];
        $model->title = $dto['title'];
        $model->message = $dto['message'];
        $model->type = $dto['type'];
        $model->is_read = $dto['is_read'] ?? false;
        $model->payload = $dto['payload'] ?? null;

        $this->prepareAuditActive($model);
        $this->prepareAuditInsert($model);
        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.notification.notification.stored');
    }

    public function prepare($dto)
    {
        if (isset($dto['user_uuid']))
            $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'user_id' => ['nullable', 'integer', new ExistsId(new User)],
            'user_uuid' => ['required_without:user_id', 'uuid', new ExistsUuid(new User)],

            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
            'type' => ['required', Rule::enum(NotificationType::class)],
            'is_read' => ['nullable', 'boolean'],
            'payload' => ['nullable', 'array'],
        ];
    }
}
