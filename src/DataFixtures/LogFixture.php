<?php

namespace App\DataFixtures;

use App\Message\LogData;
use App\Entity\Log;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LogFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $logData1 = new LogData(
            'USER-SERVICE', 
            new DateTime('25/Sep/2022:9:30:59 +0000'),
            'POST', 
            '/users HTTP/1.1',
            201
        );

        $log1 = (new Log())
            ->setServiceName($logData1->getServiceName())
            ->setTimestamp($logData1->getTimestamp())
            ->setRequestMethod($logData1->getRequestMethod())
            ->setRequestUri($logData1->getRequestUri())
            ->setStatusCode($logData1->getStatusCode());


        $logData2 = new LogData(
            'RANDOM-SERVICE', 
            new DateTime('25/Sep/2022:15:50:59 +0000'),
            'POST', 
            '/randoms HTTP/1.1',
            201
        );
    
        $log2 = (new Log())
            ->setServiceName($logData2->getServiceName())
            ->setTimestamp($logData2->getTimestamp())
            ->setRequestMethod($logData2->getRequestMethod())
            ->setRequestUri($logData2->getRequestUri())
            ->setStatusCode($logData2->getStatusCode());
        $manager->persist($log1);
        $manager->persist($log2);

        $manager->flush();
    }
}
