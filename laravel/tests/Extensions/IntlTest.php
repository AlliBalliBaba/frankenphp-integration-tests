<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class IntlTest extends FeatureTestCase
{

    #[Test]
    public function show_first_day_of_the_week()
    {
        $calendar = \IntlCalendar::createInstance('Europe/Vienna', 'de_DE');

        $this->fetchParallelTimes(new TestRequest("/intl"), 100, function (Response $response) use ($calendar) {
            $this->assertOk($response);
            $this->assertJsonResponse([
                'first_day_of_week' => $calendar->getFirstDayOfWeek(),
            ], $response);
        });
    }

}
