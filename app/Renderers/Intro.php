<?php

namespace App\Renderers;

use App\Helpers\Terminal;
use App\enums\AnsiiConstants;
use App\Exceptions\FileNotFoudException;
use Engine\Core\GameData;

class Intro
{
    public function render(GameData $gameData): void
    {
        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);
        $this->createBackgroundColor();

        fwrite(STDOUT, AnsiiConstants::MOVECURSORTOPLEFT);
        // get the padding for top
        $logo = $this->readFile('intro.txt');
        $logoArray = explode(PHP_EOL, $logo);
        $paddingTop = Terminal::calculateTopPadding(count($logoArray));

        fwrite(STDOUT, str_repeat(PHP_EOL, $paddingTop) . "\n");
        foreach ($logoArray as $line) {

            $paddingLeft = Terminal::calculateLeftPadding(strlen($line));

            fwrite(STDOUT, str_repeat("\033[45m \033[0m", $paddingLeft));
            fwrite(STDOUT, $line . PHP_EOL);
        }

        $tekst = 'Press any key';
        fwrite(STDOUT, PHP_EOL);
        fwrite(STDOUT, str_repeat("\033[45m \033[0m", Terminal::calculateLeftPadding(strlen($tekst))));
        fwrite(STDOUT, $tekst . PHP_EOL);

    }

    protected function readFile(string $filename): string
    {
        if (is_file(__DIR__ . '/../views/intro.txt')) {
            return file_get_contents(__DIR__ . '/..//views/intro.txt');
        }
        throw new FileNotFoudException(sprintf('Could not read %s.' . $filename));
    }

    public function createBackgroundColor(): void
    {
        $cols = Terminal::getTerminalWidth();
        $rows = Terminal::getTerminalHeight();
        // create background color
        for ($i = 0; $i < $rows; $i++) {
            fwrite(STDOUT, str_repeat("\033[45m \033[0m", $cols) . "\n");
        }
    }
}
