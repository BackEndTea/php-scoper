<?php

declare(strict_types=1);

/*
 * This file is part of the humbug/php-scoper package.
 *
 * Copyright (c) 2017 Théo FIDRY <theo.fidry@gmail.com>,
 *                    Pádraic Brady <padraic.brady@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Humbug\PhpScoper\PhpParser\NodeVisitor\Collection;

/**
 * Utility class that holds all the Whitelisted items
 */
final class WhiteListedNamespaceCollection
{
    /**
     * @var string[]
     */
    private $whiteListedItems = [];

    private $nonMatchedItems = [];

    public function __construct(array $whiteListedItems)
    {
        $this->whiteListedItems = $whiteListedItems;
    }

    public function isWhiteListed(string $value): bool
    {
        if (0 === count($this->whiteListedItems)) {
            return false;
        }

        if (in_array($value, $this->whiteListedItems, true)) {
            return true;
        }
        if (in_array($value, $this->nonMatchedItems, true)) {
            return false;
        }

        foreach ($this->whiteListedItems as $whiteListedItem) {
            if (fnmatch($whiteListedItem, $value, FNM_NOESCAPE)) {
                $this->whiteListedItems[] = $value;
                return true;
            }
        }
        $this->nonMatchedItems[] = $value;
        return false;

    }

}