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
namespace Magebit\Faq\Block;

use \Magebit\Faq\Api\QuestionRepositoryInterface;

class QuestionList extends \Magento\Framework\View\Element\Template
{
    /**
     * @var $questionRepository \Magebit\Faq\Api\QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * Construct
     *
     * @param $context \Magento\Framework\View\Element\Template\Context
     * @param $searchCriteria \Magento\Framework\Api\SearchCriteriaInterface
     * @param $searchCriteriaBuilder \Magento\Framework\Api\SearchCriteriaBuilder
     * @param $sortOrderBuilder \Magento\Framework\Api\SortOrderBuilder
     * @param $questionRepository \Magebit\Faq\Api\QuestionRepositoryInterface
     * @param $data array
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\SortOrderBuilder $sortOrderBuilder,
        QuestionRepositoryInterface $questionRepository,
        array $data = [],
    ) {
        parent::__construct($context, $data);
        $this->questionRepository = $questionRepository;
        $this->searchCriteria = $searchCriteria;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * Retrieves all FAQ questions
     *
     * @return array FAQ questions
     */
    public function getQuestions()
    {
        $data = [];
        $sortOrder = $this->sortOrderBuilder->setField('position')->setDirection('DESC')->create();
        $searchCriter = $this->searchCriteriaBuilder->addFilter('status', 1)->setSortOrders([$sortOrder])->create();
        $items = $this->questionRepository->getList($searchCriter);
        foreach ($items->getItems() as $item) {
            $data[] = $item;
        }
        return $data;
    }

}
