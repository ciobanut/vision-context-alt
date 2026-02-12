<?php

namespace VisionContextAlt\Services;

use VisionContextAlt\Api\ExternalApi;

class DataService
{

    private ExternalApi $external_api;
    private AltTextQualityService $quality_service;
    private MediaQueryService $media_query_service;
    private QueueService $queue_service;
    private AltTextUpdateService $alt_update_service;

    public function __construct(
        ExternalApi $external_api,
        AltTextQualityService $quality_service,
        MediaQueryService $media_query_service,
        QueueService $queue_service,
        AltTextUpdateService $alt_update_service
    ) {
        $this->external_api = $external_api;
        $this->quality_service = $quality_service;
        $this->media_query_service = $media_query_service;
        $this->queue_service = $queue_service;
        $this->alt_update_service = $alt_update_service;
    }

    public function process_next(): array
    {
        if ($this->queue_service->is_empty()) {
            $items = $this->media_query_service->collect_items();
            $this->queue_service->set_queue($items);
        }

        $item = $this->queue_service->get_next_item();

        if ($item === null) {
            return ['status' => 'empty', 'message' => 'No items to process.'];
        }

        $existing_alt = isset($item['alt_text']) ? (string) $item['alt_text'] : '';

        if ($this->quality_service->is_good($existing_alt)) {
            return ['status' => 'skipped', 'message' => 'Alt text already acceptable.'];
        }

        $payload = [
            'title' => $item['post_title'] ?? '',
            'categories' => $item['categories'] ?? [],
            'tags' => $item['tags'] ?? [],
            'image_id' => $item['attachment_id'] ?? 0,
        ];

        $alt_text = $this->external_api->request_alt_text($payload);

        if ($alt_text !== '' && isset($item['attachment_id'])) {
            $this->alt_update_service->update_attachment_alt((int) $item['attachment_id'], $alt_text);
        }

        return ['status' => 'processed', 'message' => 'Item processed.'];
    }
}
