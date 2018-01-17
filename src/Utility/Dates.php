<?php

namespace App\Utility;

class Dates
{
    public static function getLapsedTime($date)
    {
        $dateStart = new \DateTime($date);
        $dateEnd = new \DateTime('now');

        $diff = $dateEnd->diff($dateStart);

        $lapsedTime = '';

        if($diff->days > 0) {

            if($diff->days == 1) {

                $lapsedTime =  $diff->days . ' day';
            }

            if($diff->days > 1) {

                $lapsedTime =  $diff->days . ' days';
            }
        }
        else {

            if ($diff->h > 0) {

                if ($diff->h == 1) {

                    $lapsedTime = $diff->h . ' hour';
                }

                if ($diff->h > 1) {

                    $lapsedTime = $diff->h . ' hours';
                }

            } else {

                if ($diff->i > 0) {

                    if ($diff->i == 1) {

                        $lapsedTime = $diff->i . ' minute';
                    }

                    if ($diff->i > 1) {

                        $lapsedTime = $diff->i . ' minutes';
                    }

                }
                else {

                    if ($diff->s > 0) {

                        if ($diff->s == 1) {

                            $lapsedTime = $diff->s . ' second';
                        }

                        if ($diff->s > 1) {

                            $lapsedTime = $diff->s . ' seconds';
                        }
                    }
                }
            }
        }

        return $lapsedTime;
    }
}