<?php declare(strict_types=1);

namespace Zalas\Toolbox\Cli\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Zalas\Toolbox\Tool\Tool;
use Zalas\Toolbox\UseCase\ListTools;

final class ListCommand extends Command
{
    public const NAME = 'list-tools';

    private $listTools;

    public function __construct(ListTools $listTools)
    {
        parent::__construct(self::NAME);

        $this->listTools = $listTools;
    }

    protected function configure()
    {
        $this->setDescription('Lists available tools');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tools = \call_user_func($this->listTools);

        $style = $this->createStyle($input, $output);
        $style->title('Available tools');
        $style->table(
            ['Name', 'Summary'],
            $tools->map(function (Tool $tool) {
                return [\sprintf('<info>%s</info>', $tool->name()), $tool->summary().PHP_EOL.$tool->website().PHP_EOL];
            })->toArray()
        );
    }

    private function createStyle(InputInterface $input, OutputInterface $output): StyleInterface
    {
        return new SymfonyStyle($input, $output);
    }
}
