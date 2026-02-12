<?php

namespace VisionContextAlt\Services;

class AltTextQualityService
{

    public function is_good(string $alt_text): bool
    {
        $alt_text = trim($alt_text);

        if ($alt_text === '') {
            return false;
        }

        return strlen($alt_text) >= 10;
    }
}
