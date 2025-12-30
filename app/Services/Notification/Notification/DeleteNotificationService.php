<?php

namespace App\Services\Notification\Notification;

use App\Models\Notification\Notification;
use App\Rules\ExistsId;
use App\Rules\ExistsUuid;
use App\Services\DefaultService;
use App\Services\ServiceInterface;

class DeleteNotificationService extends DefaultService implements ServiceInterface
{
    public function process($dto)
    {
        $dto = $this->prepare($dto);

        $model = Notification::find($dto['notification_id']);

        $this->validateVersion($model, $dto['version']);
        $this->activeAndRemoveData($model, $dto);

        $this->results['data'] = [];
        $this->results['message'] = __('success.notification.notification.deleted');
    }

    public function prepare($dto)
    {
        if(isset($dto['notification_uuid']))
            $dto['notification_id'] = $this->findIdByUuid(Notification::query(), $dto['notification_uuid']);

        return $dto;
    }

    public function rules($dto)
    {
        return [
            'notification_id' => ['nullable', 'integer', new ExistsId(new Notification)],
            'notification_uuid' => ['required_without:notification_id', 'uuid', new ExistsUuid(new Notification)],

            'version' => ['required', 'integer'],
        ];
    }
}
