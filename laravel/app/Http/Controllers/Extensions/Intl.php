<?php

namespace App\Http\Controllers\Extensions;

class Intl
{

    public function calendar()
    {
        $calendar = \IntlCalendar::createInstance('Europe/Vienna', 'de_DE');

        return [
            'first_day_of_week' => $calendar->getFirstDayOfWeek(),
        ];
    }

}
