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
        return match ($this) {
            self::HEAD => __('painlocation.head'),
            self::NECK => __('painlocation.neck'),

            self::LEFT_SHOULDER => __('painlocation.left_shoulder'),
            self::RIGHT_SHOULDER => __('painlocation.right_shoulder'),
            self::UPPER_BACK => __('painlocation.upper_back'),

            self::LEFT_UPPER_ARM => __('painlocation.left_upper_arm'),
            self::RIGHT_UPPER_ARM => __('painlocation.right_upper_arm'),
            self::LEFT_ELBOW => __('painlocation.left_elbow'),
            self::RIGHT_ELBOW => __('painlocation.right_elbow'),
            self::LEFT_FOREARM => __('painlocation.left_forearm'),
            self::RIGHT_FOREARM => __('painlocation.right_forearm'),
            self::LEFT_WRIST => __('painlocation.left_wrist'),
            self::RIGHT_WRIST => __('painlocation.right_wrist'),
            self::LEFT_HAND => __('painlocation.left_hand'),
            self::RIGHT_HAND => __('painlocation.right_hand'),

            self::CHEST => __('painlocation.chest'),
            self::ABDOMEN => __('painlocation.abdomen'),
            self::LOWER_BACK => __('painlocation.lower_back'),

            self::LEFT_HIP => __('painlocation.left_hip'),
            self::RIGHT_HIP => __('painlocation.right_hip'),
            self::LEFT_UPPER_LEG => __('painlocation.left_upper_leg'),
            self::RIGHT_UPPER_LEG => __('painlocation.right_upper_leg'),
            self::LEFT_KNEE => __('painlocation.left_knee'),
            self::RIGHT_KNEE => __('painlocation.right_knee'),
            self::LEFT_LOWER_LEG => __('painlocation.left_lower_leg'),
            self::RIGHT_LOWER_LEG => __('painlocation.right_lower_leg'),
            self::LEFT_ANKLE => __('painlocation.left_ankle'),
            self::RIGHT_ANKLE => __('painlocation.right_ankle'),
            self::LEFT_FOOT => __('painlocation.left_foot'),
            self::RIGHT_FOOT => __('painlocation.right_foot'),
        };
    }
}
