<?php

namespace App\Enums;

enum StatusEnum: string
{
    case Inactif = "inactif";
    case Pending = "en attente";
    case Actif = "actif";
}
