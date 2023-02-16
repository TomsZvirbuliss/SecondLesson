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
namespace Magebit\Faq\Api\Data;

/**
 * FAQ question interface.
 * @api
 * @since 100.0.1
 */
interface QuestionInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = "id";
    const QUESTION = "question";
    const ANSWER = "answer";
    const STATUS = "status";
    const POSITION = "position";
    const UPDATED_AT = "updated_at";
    /**#@-*/

    /**
     * Get question ID
     *
     * @return int|null
     */
    public function getQuestionId(): ?int;

    /**
     * Get question
     *
     * @return string|null
     */
    public function getQuestion(): ?string;

    /**
     * Get answer
     *
     * @return string|null
     */
    public function getAnswer(): ?string;

    /**
     * Get status
     *
     * @return string|null
     * @since 101.0.0
     */
    public function getStatus(): ?string;

    /**
     * Get position
     *
     * @return string|null
     */
    public function getPosition(): ?string;

    /**
     * Get updated at
     *
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * Set question
     *
     * @param string $question
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     */
    public function setQuestion($question);

    /**
     * Set answer
     *
     * @param string $answer
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     */
    public function setAnswer($answer);

    /**
     * Set status
     *
     * @param int $status
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     */
    public function setStatus($status);

    /**
     * Set position
     *
     * @param int $position
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     */
    public function setPosition($position);

}
