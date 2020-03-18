<?php

namespace App\Service;

interface TimeTransformerInterface 
{
    public function getTime(?string $time = null): ?string;
}