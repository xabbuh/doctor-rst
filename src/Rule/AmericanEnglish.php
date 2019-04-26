<?php

declare(strict_types=1);

/*
 * This file is part of DOCtor-RST.
 *
 * (c) Oskar Stark <oskarstark@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Rule;

use App\Annotations\Rule\Description;
use App\Annotations\Rule\InvalidExample;
use App\Annotations\Rule\ValidExample;
use App\Handler\Registry;

/**
 * @Description("Ensure only American English is used.")
 * @InvalidExample("This is a nice behaviour...")
 * @ValidExample("This is a nice behavior...")
 */
class AmericanEnglish extends CheckListRule
{
    public static function getGroups(): array
    {
        return [Registry::GROUP_SONATA, Registry::GROUP_SYMFONY];
    }

    public function check(\ArrayIterator $lines, int $number)
    {
        $lines->seek($number);
        $line = $lines->current();

        if (preg_match($this->pattern, $line, $matches)) {
            return sprintf($this->message, $matches[0]);
        }
    }

    public function getDefaultMessage(): string
    {
        return 'Please use American English for: %s';
    }

    public static function getList(): array
    {
        return [
            '/(B|b)ehaviour(s)?/' => null,
            '/(I|i)nitialise/i' => null,
        ];
    }
}
