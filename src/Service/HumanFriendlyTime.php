<?php

namespace App\Service;

use Carbon\Carbon;

class HumanFriendlyTime implements TimeTransformerInterface
{
    const NUMBERS = [
        "zero", "one", "two", "three", "four", 
        "five", "six", "seven", "eight", "nine", 
        "ten", "eleven", "twelve", "thirteen", 
        "fourteen", "fifteen", "sixteen", "seventeen", 
        "eighteen", "nineteen", "twenty", "twenty one", 
        "twenty two", "twenty three", "twenty four", 
        "twenty five", "twenty six", "twenty seven", 
        "twenty eight", "twenty nine"
    ];

    public function getTime(?string $time = null): ?string
    {
        if ($time === null) {
            $now = Carbon::now();
            return $this->timeToHumanFriendly($now->format('h'), $now->format('i'));
        }

        try {
            $timeGiven = Carbon::createFromFormat('H:i', $time);

            $errors = $timeGiven->getLastErrors();
            
            if (isset($errors['warning_count']) && $errors['warning_count'] > 0) {
                return null;
            }

        } catch (\Exception $e) {
            return null;
        }

        return $this->timeToHumanFriendly($timeGiven->format('h'), $timeGiven->format('i'));
    }

    protected function timeToHumanFriendly(int $hour, int $minute): ?string
    {
        if ($minute === 0) {
            return self::NUMBERS[$hour] .  " o' clock" ;
        }
        
        if ($minute === 1) {
            return "one minute past " . self::NUMBERS[$hour]; 
        }

        if ($minute === 59) {
            return "one minute to " . self::NUMBERS[($hour % 12) + 1]; 
        }

        if ($minute === 15) {
            return "quarter past " . self::NUMBERS[$hour]; 
        }

        if ($minute === 30) {
            return "half past " . self::NUMBERS[$hour]; 
        }

        if ($minute === 45) {
            return "quarter to " . (self::NUMBERS[($hour % 12) + 1]); 
        }

        if ($minute <= 30) {
            return self::NUMBERS[$minute] . " minutes past " . self::NUMBERS[$hour]; 
        }

        if ($minute > 30) {
            return self::NUMBERS[60 - $minute] . " minutes to " . self::NUMBERS[($hour % 12) + 1]; 
        }

        return null;
    } 
}