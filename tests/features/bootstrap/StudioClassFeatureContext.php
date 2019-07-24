<?php

declare(strict_types=1);

use Imbo\BehatApiExtension\Context\ApiContext;

class StudioClassFeatureContext extends ApiContext
{
    /**
     * @BeforeScenario
     */
    public static function clearStorage()
    {
        $storagePath = dirname(__DIR__, 3).'/var/storage';
        file_put_contents($storagePath, "");
    }

    /**
     * @Given there is class for :date with name :name
     */
    public function thereIsClassForWithName($date, $name)
    {
        $startDate = new \DateTime($date);
        $classParams = [
            "name" => $name,
            "start_date" => $startDate->format("Y-m-d"),
            "end_date" => $startDate->add(new DateInterval("P2D"))->format("Y-m-d"),
            "capacity"=> 10
        ];
        $body = json_encode($classParams);
        $this->setRequestBody($body);
        $this->setRequestHeader("Content-Type", "application/json");
        $this->requestPath("api/classes", 'POST');
    }
}
