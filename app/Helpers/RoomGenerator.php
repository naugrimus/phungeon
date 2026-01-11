<?php

namespace App\Helpers;

use App\enums\Elements;

class RoomGenerator
{
    protected array $room;

    protected array $carveDirections;

    protected int $width;

    protected int $height;

    public function __construct()
    {
        $this->width = 71;
        $this->height = 19;
        $this->carveDirections = [
            [0, -2],
            [0, 2],
            [-2, 0],
            [2, 0],
        ];

    }

    public function generate()
    {

        $this->room = array_fill(0, $this->height,
            array_fill(0, $this->width, Elements::WALL));

        $startX = 1;
        $startY = 1;
        $this->room[$startY][$startX] = Elements::FLOOR;

        $this->carve($startX, $startY, $this->carveDirections, $this->width, $this->height);

        $this->createExits();

        return $this->room;

    }

    protected function carve($x, $y, $dirs, $width, $height)
    {
        shuffle($dirs);

        foreach ($dirs as [$dx, $dy]) {
            $nx = $x + $dx;
            $ny = $y + $dy;

            // 👇 This automatically protects the border
            if ($nx > 0 && $ny > 0 && $nx < $width - 1 && $ny < $height - 1) {

                if ($this->room[$ny][$nx] === Elements::WALL) {
                    $this->room[$y + intdiv($dy, 2)][$x + intdiv($dx, 2)] = Elements::FLOOR;
                    $this->room[$ny][$nx] = Elements::FLOOR;
                    $this->carve($nx, $ny, $dirs, $width, $height);
                }
            }
        }

        return $this->room;
    }

    protected function createExits(): void
    {
        $exits = [
            [intdiv($this->width, 2), 0, 0, 1],                      // top
            [intdiv($this->width, 2), $this->height - 1, 0, -1],    // bottom
            [0, intdiv($this->height, 2), 1, 0],                    // left
            [$this->width - 1, intdiv($this->height, 2), -1, 0],    // right
        ];

        foreach ($exits as [$x, $y, $dx, $dy]) {
            $this->room[$y][$x] = Elements::FLOOR;

            $cx = $x + $dx;
            $cy = $y + $dy;

            while (
                $cx > 0 && $cy > 0 &&
                $cx < $this->width - 1 &&
                $cy < $this->height - 1
            ) {
                if ($this->room[$cy][$cx] === Elements::FLOOR) {
                    break;
                }

                $this->room[$cy][$cx] = Elements::FLOOR;
                $cx += $dx;
                $cy += $dy;
            }
        }
    }
}
