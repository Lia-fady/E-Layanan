<?php

use App\Helpers\LogbookTimeHelper;
use PHPUnit\Framework\TestCase;

class LogbookTimeHelperTest extends TestCase
{
    public function testFormatsActivityTimestampWithWibTime():
    {
        $result = LogbookTimeHelper::formatActivityDateTime('2026-08-10 07:32:00');

        $this->assertSame('10 Aug 2026', $result['date']);
        $this->assertSame('07:32', $result['time']);
    }

    public function testOmitsTimeWhenOnlyDateIsAvailable():
    {
        $result = LogbookTimeHelper::formatActivityDateTime('2026-08-10');

        $this->assertSame('10 Aug 2026', $result['date']);
        $this->assertSame('', $result['time']);
    }
}
