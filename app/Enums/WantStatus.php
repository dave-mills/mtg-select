<?php

namespace App\Enums;

enum WantStatus: string
{

    case null = 'none';
    case NotWant = 'nope';
    case Want = 'yes';
    case ReallyWant = 'very yes';
    case ReallyReallyWant = 'OMG YES';

}
