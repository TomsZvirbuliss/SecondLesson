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
namespace Magebit\Faq\Api;


/**
 * Interface for managing faq questions.
 * @api
 * @since 100.0.2
 */
interface QuestionManagmentInterface
{
    /**
     * Set question to enabled
     *
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     */
    public function enableQuestion();

    /**
     * Set question to disabled
     *
     * @return $this
     */
    public function disableQuestion();
}
