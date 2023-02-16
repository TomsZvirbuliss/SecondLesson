<?php
/**
 * This file is part of the Magebit package.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magebit Faq
 * to newer versions in the future.
 *
 * @copyright Copyright (c) 2022 Magebit, Ltd. (https://magebit.com/)
 * @license   GNU General Public License ("GPL") v3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Magebit\Faq\Model;

use Magebit\Faq\Api\QuestionManagmentInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * FAQ question managment Model
 *
 * @api
 * @since 100.0.2
 */
class QuestionManagment extends AbstractModel implements QuestionManagmentInterface
{
    /**#@+
     * FAQ Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const STATUS = 'status';
    /**#@-*/

    /**
     * Enable question
     *
     * @return QuestionManagmentInterface|Question
     */
    public function enableQuestion()
    {
        return $this->setData(self::STATUS, 1);
    }

    /**
     * Disable question
     *
     * @return QuestionManagmentInterface|Question
     */
    public function disableQuestion()
    {
        return $this->setData(self::STATUS, 0);
    }
}
