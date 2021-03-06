<?php declare(strict_types=1);

namespace Zalas\Toolbox\Tests\UseCase;

use PHPUnit\Framework\TestCase;
use Zalas\Toolbox\Tool\Collection;
use Zalas\Toolbox\Tool\Tool;
use Zalas\Toolbox\Tool\Tools;
use Zalas\Toolbox\UseCase\ListTools;

class ListToolsTest extends TestCase
{
    public function test_it_returns_loaded_tools()
    {
        $tools = Collection::create([
            $this->prophesize(Tool::class)->reveal(),
            $this->prophesize(Tool::class)->reveal(),
        ]);

        $repository = $this->prophesize(Tools::class);
        $repository->all()->willReturn($tools);

        $useCase = new ListTools($repository->reveal());

        $this->assertSame($tools, $useCase());
    }
}
