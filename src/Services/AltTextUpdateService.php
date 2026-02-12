<?php

namespace VisionContextAlt\Services;

class AltTextUpdateService
{

    public function update_attachment_alt(int $attachment_id, string $alt_text): void
    {
        update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);
    }
}
