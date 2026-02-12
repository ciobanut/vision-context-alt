<?php

namespace VisionContextAlt\Services;

class QueueService
{

    private string $queue_option = 'visioncontext_alt_queue';

    public function set_queue(array $items): void
    {
        update_option($this->queue_option, array_values($items));
    }

    public function get_next_item(): ?array
    {
        $queue = $this->get_queue();

        if ($queue === []) {
            return null;
        }

        $item = array_shift($queue);
        update_option($this->queue_option, $queue);

        return is_array($item) ? $item : null;
    }

    public function is_empty(): bool
    {
        return $this->get_queue() === [];
    }

    private function get_queue(): array
    {
        $queue = get_option($this->queue_option, []);

        return is_array($queue) ? $queue : [];
    }
}
