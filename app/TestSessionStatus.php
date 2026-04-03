<?php

namespace App;

enum TestSessionStatus: string
{
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}
