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

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Faq page CRUD interface.
 * @api
 * @since 100.0.0
 */
interface QuestionRepositoryInterface
{
    /**
     * Save question.
     *
     * @param \Magebit\Faq\Api\Data\QuestionInterface $question
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Magebit\Faq\Api\Data\QuestionInterface $question);

    /**
     * Retrieve question.
     *
     * @param int $questionId
     * @return \Magebit\Faq\Api\Data\QuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($questionId);

    /**
     * Retrieve questions matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magebit\Faq\Api\QuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete question.
     *
     * @param \Magebit\Faq\Api\Data\QuestionInterface $question
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Magebit\Faq\Api\Data\QuestionInterface $question);

    /**
     * Delete question by ID.
     *
     * @param int $questionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($questionId);
}
