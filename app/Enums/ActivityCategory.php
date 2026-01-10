<?php

namespace App\Enums;

enum ActivityCategory: string
{
    case WALKING = 'walking';
    case CYCLING = 'cycling';
    case SPORTS  = 'sports';
    case REST    = 'rest';

    public function label(): string
    {
        return __('activity.categories.' . $this->value);
    }
}
