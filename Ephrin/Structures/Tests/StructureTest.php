<?php


namespace Ephrin\Structures\Tests;



use Ephrin\Structures\ArrayStructure;

class StructureTest extends \PHPUnit_Framework_TestCase
{



    public function testArrayKeysConvertsToIntegers(){
        $a = [];

        $key = (string)1;

        $this->assertTrue(is_string($key));

        $a[$key] = $key;

        $this->assertFalse(is_string(array_pop(array_keys($a))));

    }




    public function testArrays()
    {
        $total = 1000000;


        $try1 = array_fill(0, $total, 1);
        $try1[rand(0, count($try1)-1)] = null;

        $try2 = array_fill(0, $total, 1);
        $try2[rand(0, count($try1)-1)] = null;
        $try2[(string)count($try2)] = 'value';

        $uk = rand(0, $total);
        unset($try2[$uk]);

        print 'isSequentialFastest:'.PHP_EOL;

        \PHP_Timer::start();
        $isHashFalse = !ArrayStructure::isSequentialFastest($try1);
        $time = \PHP_Timer::stop();
        print \PHP_Timer::secondsToTimeString($time) . PHP_EOL;

        \PHP_Timer::start();
        $isHashTrue = !ArrayStructure::isSequentialFastest($try2);
        $time = \PHP_Timer::stop();
        print \PHP_Timer::secondsToTimeString($time) . PHP_EOL;

        $this->assertFalse($isHashFalse);
        $this->assertTrue($isHashTrue);


        print 'isSequentialSimple:'.PHP_EOL;

        \PHP_Timer::start();
        $isSeqFalse = !ArrayStructure::isSequentialSimple($try1);
        $time = \PHP_Timer::stop();
        print \PHP_Timer::secondsToTimeString($time) . PHP_EOL;

        \PHP_Timer::start();
        $isSeqTrue = !ArrayStructure::isSequentialSimple($try2);
        $time = \PHP_Timer::stop();
        print \PHP_Timer::secondsToTimeString($time) . PHP_EOL;

        $this->assertFalse($isSeqFalse);
        $this->assertTrue($isSeqTrue);

        print 'isSequentialExotic:'.PHP_EOL;

        \PHP_Timer::start();
        $isSeqTrue = ArrayStructure::isSequentialExotic($try1);
        $time = \PHP_Timer::stop();
        print \PHP_Timer::secondsToTimeString($time) . PHP_EOL;

        \PHP_Timer::start();
        $isSeqFalse = ArrayStructure::isSequentialExotic($try2);
        $time = \PHP_Timer::stop();
        print \PHP_Timer::secondsToTimeString($time) . PHP_EOL;

        $this->assertFalse($isSeqFalse);
        $this->assertTrue($isSeqTrue);


        print 'isAssoc:'.PHP_EOL;

        \PHP_Timer::start();
        $isAssocFalse = ArrayStructure::isAssoc($try1);
        $time = \PHP_Timer::stop();
        print \PHP_Timer::secondsToTimeString($time) . PHP_EOL;

        \PHP_Timer::start();
        $isAssocTrue = ArrayStructure::isAssoc($try2);
        $time = \PHP_Timer::stop();
        print \PHP_Timer::secondsToTimeString($time) . PHP_EOL;

        $this->assertFalse($isAssocFalse);
        $this->assertTrue($isAssocTrue);





    }



} 