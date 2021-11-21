<?php

namespace App\Helpers;

class Helper
{
   static function formatCnpj($value)
    {
        $cnpj = preg_replace("/\D/", '', $value);

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj);
    }
}
