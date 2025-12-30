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

class UpdateNotificationService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Notification::find($dto['notification_id']);

        $model->user_id = $dto['user_id'] ?? $model->user_id;
        $model->title = $dto['title'] ?? $model->title;
        $model->message = $dto['message'] ?? $model->message;
        $model->type = $dto['type'] ?? $model->type;
        $model->is_read = $dto['is_read'] ?? $model->is_read;

        $this->validateVersion($model, $dto['version']);
        $this->prepareAuditUpdate($model);

        $model->save();

        $this->results['data'] = $model;
        $this->results['message'] = __('success.notification.notification.updated');
    }

    public function prepare($dto)
    {
        if (isset($dto['notification_uuid']))
            $dto['notification_id'] = $this->findIdByUuid(Notification::query(), $dto['notification_uuid']);

        if (isset($dto['user_uuid']))
            $dto['user_id'] = $this->findIdByUuid(User::query(), $dto['user_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'notification_id' => ['nullable', 'integer', new ExistsId(new Notification)],
            'notification_uuid' => ['required_without:notification_id', 'uuid', new ExistsUuid(new Notification)],

            'user_id' => ['nullable', 'integer', new ExistsId(new User)],
            'user_uuid' => ['nullable', 'uuid', new ExistsUuid(new User)],

            'title' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'type' => ['nullable', Rule::enum(NotificationType::class)],
            'is_read' => ['nullable', 'boolean'],
            
            'version' => ['required', 'integer'],
        ];
    }
}
