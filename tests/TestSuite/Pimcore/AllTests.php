<?php
//require_once 'PHPUnit/Framework.php';

class TestSuite_Pimcore_AllTests extends Test_SuiteBase
{
    public static function suite()
    {
        $suite = new TestSuite_Basics_AllTests('Pimcore');

        $tests = [
            \TestSuite\Pimcore\MailTest::class
        ];

        foreach ($tests as $test) {
            print("    - " . $test . "\n");
            $suite->addTestSuite($test);
        }

        return $suite;
    }
}
