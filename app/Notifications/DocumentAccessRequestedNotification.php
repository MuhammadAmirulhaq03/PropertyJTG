<?php

namespace App\Notifications;

use App\Models\DocumentAccessRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DocumentAccessRequestedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public User $customer,
        public DocumentAccessRequest $docRequest,
    ) {}

    public function via(object $notifiable): array
    {
        // Keep it simple and reliable; database channel only
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'document_access_requested',
            'customer_id' => $this->customer->id,
            'customer_name' => $this->customer->name,
            'note' => $this->docRequest->note,
            'requested_at' => optional($this->docRequest->requested_at)->toIso8601String(),
            'request_id' => $this->docRequest->id,
            'message' => __('Permintaan peninjauan dokumen dari :name.', ['name' => $this->customer->name]),
            'link' => route('agent.document-requests.index'),
        ];
    }
}

