<?php
require './vendor/autoload.php';

use Ysp\Holiday;

class CheckTest
{
    function startsWith($string, $prefix)
    {
        $len = strlen($prefix);
        if ($len == 0) {
            return true;
        }
        return (substr($string, 0, $len) === $prefix);
    }

    /**
     * 断言为真
     * @param bool $value 要检查的值
     * @param string $message 如果断言失败时要显示的消息
     */
    function assertTrue($value, $message = '')
    {
        if (!$value) {
            trigger_error($message ?: 'Assertion failed: expected true', E_USER_ERROR);
        }
        echo '断言为真成立' . PHP_EOL;
    }

    /**
     * 断言为假
     * @param bool $value 要检查的值
     * @param string $message 如果断言失败时要显示的消息
     */
    function assertFalse($value, $message = '')
    {
        if ($value) {
            trigger_error($message ?: 'Assertion failed: expected false', E_USER_ERROR);
        }
        echo '断言为假成立' . PHP_EOL;
    }

    /**
     * 断言两个值相等
     * @param mixed $expected 预期值
     * @param mixed $actual 实际值
     * @param string $message 如果断言失败时要显示的消息
     */
    function assertEquals($expected, $actual, $message = '')
    {
        if ($expected != $actual) {
            $message = $message ?: sprintf('Assertion failed: expected %s, got %s', var_export($expected, true), var_export($actual, true));
            trigger_error($message, E_USER_ERROR);
        }
        echo '断言相等' . PHP_EOL;
    }

    public function testYear2023()
    {
        $year = 2023;
        //法定节假日
        $holiday_3 = [
            '2023-01-01',
            '2023-01-22',
            '2023-01-23',
            '2023-01-24',
            '2023-04-05',
            '2023-05-01',
            '2023-06-22',
            '2023-09-29',
            '2023-10-01',
            '2023-10-02',
            '2023-10-03',
        ];
        //节假日
        $holiday_4 = [
            '2022-12-31',
            '2023-01-02',
            '2023-01-21',
            '2023-01-25',
            '2023-01-26',
            '2023-01-27',
            '2023-04-29',
            '2023-04-30',
            '2023-05-02',
            '2023-05-03',
            '2023-06-23',
            '2023-06-24',
            '2023-09-30',
            '2023-10-04',
            '2023-10-05',
            '2023-10-06',
        ];
        //上班
        $work = [
            '2023-01-28',
            '2023-01-29',
            '2023-04-23',
            '2023-05-06',
            '2023-06-25',
            '2023-10-07',
            '2023-10-08',
        ];
        $holiday = new Holiday();
        foreach ($holiday_3 as $v) {
            $result = $holiday->isHoliday(strtotime($v), Holiday::TYPE_HOLIDAY);
            if ($result != true) {
                echo "{$v}不是法定节假日\n";
            }
            $this->assertTrue($result);
        }
        foreach ($holiday_4 as $v) {
            $result = $holiday->isHoliday(strtotime($v), Holiday::TYPE_VACATION);
            $this->assertTrue($result);
        }
        foreach ($work as $v) {
            $result = $holiday->isHoliday(strtotime($v));
            $this->assertFalse($result);
        }
        $day3 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_HOLIDAY);
        $this->assertEquals(11, $day3);

    }

    public function testYear2022()
    {
        $year = 2022;
        //法定节假日
        $holiday_3 = [
            '2022-01-01',
            '2022-01-31',
            '2022-02-01',
            '2022-02-02',
            '2022-04-05',
            '2022-05-01',
            '2022-06-03',
            '2022-09-10',
            '2022-10-01',
            '2022-10-02',
            '2022-10-03',
        ];
        //节假日
        $holiday_4 = [
            '2022-01-02',
            '2022-01-03',
            '2022-02-03',
            '2022-02-04',
            '2022-02-05',
            '2022-02-06',
            '2022-04-03',
            '2022-04-04',
            '2022-04-30',
            '2022-05-02',
            '2022-05-03',
            '2022-05-04',
            '2022-06-04',
            '2022-06-05',
            '2022-09-11',
            '2022-09-12',
            '2022-10-04',
            '2022-10-05',
            '2022-10-06',
            '2022-10-07',
        ];
        //上班
        $work = ['2022-01-29', '2022-01-30', '2022-04-02', '2022-04-24', '2022-05-07', '2022-10-08', '2022-10-09',];
        $holiday = new Holiday();
        foreach ($holiday_3 as $v) {
            $result = $holiday->isHoliday(strtotime($v), Holiday::TYPE_HOLIDAY);
            $this->assertTrue($result);
        }
        foreach ($holiday_4 as $v) {
            $result = $holiday->isHoliday(strtotime($v), Holiday::TYPE_VACATION);
            $this->assertTrue($result);
        }
        foreach ($work as $v) {
            $result = $holiday->isHoliday(strtotime($v));
            $this->assertFalse($result);
        }

        $day3 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_HOLIDAY);
        $this->assertEquals(11, $day3);
    }

    public function testYear2021()
    {
        $year = 2021;
        $holiday = new Holiday();
        $day1 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_ALL);
        $this->assertEquals(115, $day1);
        $day3 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_HOLIDAY);
        $this->assertEquals(11, $day3);
    }

    public function testYear2020()
    {
        $year = 2020;
        $holiday = new Holiday();
        $day1 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_ALL);
        $this->assertEquals(117, $day1);
        $day3 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_HOLIDAY);
        $this->assertEquals(10, $day3);
    }

    public function testYear2019()
    {
        $year = 2019;
        $holiday = new Holiday();
        $day1 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_ALL);
        $this->assertEquals(115, $day1);
        $day3 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_HOLIDAY);
        $this->assertEquals(11, $day3);
    }

    public function testYear2018()
    {
        $year = 2018;
        $holiday = new Holiday();
        $day1 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_ALL);
        $this->assertEquals(115, $day1);
        $day3 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_HOLIDAY);
        $this->assertEquals(11, $day3);
    }

    public function testYear2017()
    {
        $year = 2017;
        $holiday = new Holiday();
        $day1 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_ALL);
        $this->assertEquals(116, $day1);
        $day3 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_HOLIDAY);
        $this->assertEquals(11, $day3);
    }

    public function testYear2014()
    {
        $year = 2014;
        $holiday = new Holiday();
        $day1 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_ALL);
        $this->assertEquals(115, $day1);
        $day3 = $holiday->count(strtotime("{$year}-1-1"), strtotime("{$year}-12-31"), Holiday::TYPE_HOLIDAY);
        $this->assertEquals(11, $day3);
    }
}

$checkTest = new CheckTest();
$methods = get_class_methods($checkTest);
foreach ($methods as $method) {
    if ($checkTest->startsWith($method, 'test')) {
        $checkTest->$method();
    }
}
