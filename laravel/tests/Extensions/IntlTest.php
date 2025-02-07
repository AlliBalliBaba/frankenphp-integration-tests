<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class IntlTest extends FeatureTestCase
{

    #[Test]
    public function show_first_day_of_the_week()
    {
        $calendar = \IntlCalendar::createInstance('Europe/Vienna', 'de_DE');

        $this->fetchParallelTimes(new TestRequest("/intl"), 100, function (TestResponse $response) use ($calendar) {
            $response->assertOk();
            $response->assertJson([
                'first_day_of_week' => $calendar->getFirstDayOfWeek(),
            ]);
        });
    }

}
