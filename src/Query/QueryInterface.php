<?php declare(strict_types=1);
/**
 * This file is part of the daikon-cqrs/read-model project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Daikon\ReadModel\Query;

use Daikon\Interop\ToNativeInterface;
use Daikon\Interop\FromNativeInterface;

interface QueryInterface extends FromNativeInterface, ToNativeInterface
{
}
