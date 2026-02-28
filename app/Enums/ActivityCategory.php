<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ActivityCategory: string implements HasLabel
{
    case WALKING = 'walking';
    case CYCLING = 'cycling';
    case SPORTS  = 'sports';
    case REST    = 'rest';
    case OTHER = 'other';

    public function getLabel(): string
    {
        return ucfirst(__('activitycategory.' . $this->value));
    }
}
