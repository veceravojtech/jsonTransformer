<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\FinalClassFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use Symplify\CodingStandard\Fixer\Strict\BlankLineAfterStrictTypesFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $config): void {
    $config->sets([SetList::PSR_12]);
    $config->rule(ConcatSpaceFixer::class);
    $config->rule(NoSuperfluousPhpdocTagsFixer::class);
    $config->rule(NoEmptyPhpdocFixer::class);
    $config->rule(NoExtraBlankLinesFixer::class);
    $config->rule(DeclareStrictTypesFixer::class);
    $config->rule(BlankLineAfterStrictTypesFixer::class);
    $config->rule(FinalClassFixer::class);
};
