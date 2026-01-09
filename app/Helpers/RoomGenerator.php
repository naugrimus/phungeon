<?php

namespace App\Helpers;

use App\enums\Elements;

class RoomGenerator
{
    protected array $room;

    protected array $carveDirections;

    public function __construct()
    {

        $this->carveDirections = [
            [0, -2],
            [0, 2],
            [-2, 0],
            [2, 0],
        ];

    }

    public function generate()
    {

        $tWidth = 45;
        $tHeight = 25;

        $room = $this->room = array_fill(0, $tHeight,
            array_fill(0, $tWidth, Elements::WALL));

        $startX = 1;
        $startY = 1;
        $room[$startY][$startX] = ' ';

        $room = $this->carve($startX, $startY, $room, $this->carveDirections, $tWidth, $tHeight);

        return $room;

    }

    protected function carve($x, $y, &$maze, $dirs, $width, $height)
    {
        shuffle($dirs);

        foreach ($dirs as [$dx, $dy]) {
            $nx = $x + $dx;
            $ny = $y + $dy;

            // 👇 This automatically protects the border
            if ($nx > 0 && $ny > 0 && $nx < $width - 1 && $ny < $height - 1) {

                if ($maze[$ny][$nx] === '#') {
                    $maze[$y + intdiv($dy, 2)][$x + intdiv($dx, 2)] = ' ';
                    $maze[$ny][$nx] = ' ';
                    $this->carve($nx, $ny, $maze, $dirs, $width, $height);
                }
            }
        }

        return $maze;
    }
}
