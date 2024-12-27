<?php

namespace App\Enums;

enum PasswordPart: string
{
    case Lowercase = 'abcdefghijklmnopqrstuvwxyz';
    case Uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    case Numbers = '0123456789';
    case Symbols = '!@#$%^&*()-_=+[]{}|;:",.<>?';
}
