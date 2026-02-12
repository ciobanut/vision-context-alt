<?php

namespace VisionContextAlt\Helpers;

class Utils
{

    public static function normalize_text(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/\s+/', ' ', $text);

        return $text ?? '';
    }
}
