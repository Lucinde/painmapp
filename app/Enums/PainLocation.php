<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PainLocation: string implements HasLabel
{
    // Head & neck
    case HEAD = 'head';
    case NECK = 'neck';

    // Shoulders & upper back
    case LEFT_SHOULDER = 'left shoulder';
    case RIGHT_SHOULDER = 'right shoulder';
    case UPPER_BACK = 'upper back';

    // Arms
    case LEFT_UPPER_ARM = 'left upper arm';
    case RIGHT_UPPER_ARM = 'right upper arm';
    case LEFT_ELBOW = 'left elbow';
    case RIGHT_ELBOW = 'right elbow';
    case LEFT_FOREARM = 'left forearm';
    case RIGHT_FOREARM = 'right forearm';
    case LEFT_WRIST = 'left wrist';
    case RIGHT_WRIST = 'right wrist';
    case LEFT_HAND = 'left hand';
    case RIGHT_HAND = 'right hand';

    // Torso
    case CHEST = 'chest';
    case ABDOMEN = 'abdomen';
    case LOWER_BACK = 'lower back';

    // Hips & legs
    case LEFT_HIP = 'left hip';
    case RIGHT_HIP = 'right hip';
    case LEFT_UPPER_LEG = 'left upper leg';
    case RIGHT_UPPER_LEG = 'right upper leg';
    case LEFT_KNEE = 'left knee';
    case RIGHT_KNEE = 'right knee';
    case LEFT_LOWER_LEG = 'left lower leg';
    case RIGHT_LOWER_LEG = 'right lower leg';
    case LEFT_ANKLE = 'left ankle';
    case RIGHT_ANKLE = 'right ankle';
    case LEFT_FOOT = 'left foot';
    case RIGHT_FOOT = 'right foot';

    public function getLabel(): string
    {
        return __('painlocation.' . str_replace(' ', '_', $this->value));
    }
}
