<?php

namespace App\Models;

class MailTemplate extends BaseModel
{
    protected $fillable = [
        'subject',
        'content',
        'attachment',
        'cc',
        'bcc',
        'type'
    ];

    public function parse($data)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;
            if (isset($data[trim($index)])) {
                return $data[trim($index)];
            } else {}

        }, $this->content);

        return $parsed;
    }
}
