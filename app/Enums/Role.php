<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Member = 'member';
    case Super = 'super';
    case Trainer = 'trainer';
}
