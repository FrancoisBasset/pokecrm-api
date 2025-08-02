<?php

namespace App\Service;

class MiningService {
    public static function checkPokemon($pokemon, $salt) {
        $hash = md5($pokemon->getName() . $salt);
            
        return MiningService::checkCorrectHash($pokemon->getCatchrate(), $hash);
    }

    public static function checkCorrectHash($catchrate, $hash) {
        $found = false;

        if ($catchrate === 255) {
            $found = is_numeric($hash[0]) && $hash[0] % 2 === 0;
        } else if ($catchrate >= 200) {
            $found = is_numeric($hash[0]) && is_numeric($hash[1]) && $hash[0] % 2 === 0 && $hash[1] % 2 === 0;
        } else if ($catchrate >= 150) {
            $found = is_numeric($hash[0]) && $hash[0] % 4 === 0;
        } else if ($catchrate >= 100) {
            $found = $hash[0] === $hash[2];
        } else if ($catchrate >= 50) {
            $found = str_starts_with($hash[0], '00');
        } else if ($catchrate >= 10) {
            $found = str_starts_with($hash[0], '000');
        }  else if ($catchrate >= 3) {
            $found = str_starts_with($hash[0], '000');
        }

        return $found;
    }
}
