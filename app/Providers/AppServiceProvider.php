<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('is_valid_nric', function($attribute, $value, $parameters, $validator) {
            if (!empty($value)) {
                $inNRIC = str_replace(" ", "", $value);
                if (strlen($inNRIC) > 9) {
                    if (!is_numeric($inNRIC)) {
                        return false;
                    } else {
                        return true;
                    }
                } elseif (strlen($inNRIC) == 9) {
                    $prefix = strtoupper(substr($inNRIC, 0, 1));
                    $checksum = strtoupper(substr($inNRIC, - 1));
                    $numbers = substr($inNRIC, 1, - 1);

                    if ($prefix == "T") {
                        $sum = 4;
                    } elseif ($prefix == "S") {
                        $sum = 0;
                    } else {
                        if (!is_numeric($numbers)) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                } elseif (strlen($inNRIC) == 8) {
                    $checksum = strtoupper(substr($inNRIC, - 1));
                    $numbers = substr($inNRIC, 0, - 1);
                    $sum = 0;
                } else {
                    return false;
                }

                if (($numbers < 0) or ( $numbers > 9999999)) {
                    return false;
                }

                //validate checksum against nric
                for ($i = 0; $i < 7; $i ++) {
                    $aryNum [$i] = substr($numbers, $i, 1);
                }

                $sum += $aryNum [0] * 2;
                $sum += $aryNum [1] * 7;
                $sum += $aryNum [2] * 6;
                $sum += $aryNum [3] * 5;
                $sum += $aryNum [4] * 4;
                $sum += $aryNum [5] * 3;
                $sum += $aryNum [6] * 2;

                $sum = $sum % 11;

                switch ($sum) {
                    case 0 :
                        $temp = "J";
                        break;
                    case 1 :
                        $temp = "Z";
                        break;
                    case 2 :
                        $temp = "I";
                        break;
                    case 3 :
                        $temp = "H";
                        break;
                    case 4 :
                        $temp = "G";
                        break;
                    case 5 :
                        $temp = "F";
                        break;
                    case 6 :
                        $temp = "E";
                        break;
                    case 7 :
                        $temp = "D";
                        break;
                    case 8 :
                        $temp = "C";
                        break;
                    case 9 :
                        $temp = "B";
                        break;
                    case 10 :
                        $temp = "A";
                        break;
                    default :
                        return false;
                }

                if ($temp != $checksum) {
                    return false;
                } else {
                    return true;
                }
            }
            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
