<?php

namespace tests\Formatting\Formatters;

use PHPUnit\Framework\TestCase;
use Tighten\Formatters\ExcessSpaceBetweenAndAfterImports;
use Tighten\TFormat;

class ExcessSpaceBetweenAndAfterImportsTest extends TestCase
{
    /** @test */
    function removes_excess_space_after_imports()
    {
        $file = <<<file
<?php

use B\\A as AA;
use A\\Z\\Z;


\$ok = 'thing';
file;

        $formatted = (new TFormat)->format(
            new ExcessSpaceBetweenAndAfterImports($file)
        );

        $correctlyFormatted = <<<file
<?php

use B\\A as AA;
use A\\Z\\Z;

\$ok = 'thing';
file;

        $this->assertEquals($correctlyFormatted, $formatted);
    }

    /** @test */
    function no_op_if_already_1_blank_line_after_imports()
    {
        $file = <<<file
<?php

use PhpParser\\NodeAbstract;

class CustomNode
{

}

file;

        $formatted = (new TFormat)->format(
            new ExcessSpaceBetweenAndAfterImports($file)
        );

        $this->assertEquals($file, $formatted);
    }


    /** @test */
    function does_not_remove_excess_space_before_imports()
    {
        $file = <<<file
<?php



use B\\A as AA;
use A\\Z\\Z;

\$ok = 'thing';
file;

        $formatted = (new TFormat)->format(
            new ExcessSpaceBetweenAndAfterImports($file)
        );

        $correctlyFormatted = <<<file
<?php



use B\\A as AA;
use A\\Z\\Z;

\$ok = 'thing';
file;

        $this->assertEquals($correctlyFormatted, $formatted);
    }

    /** @test */
    function removes_excess_space_between_imports()
    {
        $file = <<<file
<?php

use B\\A as AA;

use A\\Z\\Z;

\$ok = 'thing';
file;

        $formatted = (new TFormat)->format(
            new ExcessSpaceBetweenAndAfterImports($file)
        );

        $correctlyFormatted = <<<file
<?php

use B\\A as AA;
use A\\Z\\Z;

\$ok = 'thing';
file;

        $this->assertEquals($correctlyFormatted, $formatted);
    }

    /** @test */
    function does_not_alter_normal_code()
    {
        $file = <<<file
<?php

namespace tests\\Formatting\\Formatters;

use Tighten\\Formatters;

use Tighten\\Linters;


class TightenPreset implements PresetInterface
{
    public function getLinters() : array
    {
        return [
            Linters\\AlphabeticalImports::class,
            Linters\\ApplyMiddlewareInRoutes::class,
        ];
    }
}

file;

        $formatted = (new TFormat)->format(
            new ExcessSpaceBetweenAndAfterImports($file)
        );

        $correctlyFormatted = <<<file
<?php

namespace tests\\Formatting\\Formatters;

use Tighten\\Formatters;
use Tighten\\Linters;

class TightenPreset implements PresetInterface
{
    public function getLinters() : array
    {
        return [
            Linters\\AlphabeticalImports::class,
            Linters\\ApplyMiddlewareInRoutes::class,
        ];
    }
}

file;

        $this->assertEquals($correctlyFormatted, $formatted);
    }
}
