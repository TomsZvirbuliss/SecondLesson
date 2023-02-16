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

use Magebit\Faq\Api\Data;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\Data\QuestionInterfaceFactory;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\Route\Config;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Faq question repository
 *
 */
class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var ResourceQuestion
     */
    protected $resource;

    /**
     * @var QuestionFactory
     */
    protected $questionFactory;

    /**
     * @var QuestionCollectionFactory
     */
    protected $questionCollectionFactory;

    /**
     * @var QuestionSearchResultsInterface
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var QuestionInterfaceFactory
     */
    protected $dataQuestionFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var IdentityMap
     */
    private $identityMap;


    /**
     * @var Config
     */
    private $routeConfig;


    /**
     * @param ResourceQuestion $resource
     * @param QuestionFactory $questionFactory
     * @param QuestionInterfaceFactory $dataQuestionFactory
     * @param QuestionCollectionFactory $questionCollectionFactory
     * @param Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param Config $routeConfig
     */
    public function __construct(
        ResourceQuestion $resource,
        QuestionFactory $questionFactory,
        QuestionInterfaceFactory $dataQuestionFactory,
        QuestionCollectionFactory $questionCollectionFactory,
        Data\QuestionSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        Config $routeConfig
    ) {
        $this->resource = $resource;
        $this->questionFactory = $questionFactory;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataQuestionFactory = $dataQuestionFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor ?: $this->getCollectionProcessor();
        $this->routeConfig = $routeConfig;
    }

    /**
     * Save Page data
     *
     * @param QuestionInterface|Question $question
     * @return Question
     * @throws CouldNotSaveException
     */
    public function save(QuestionInterface $question)
    {
        try {
            $this->resource->save($question);
        } catch (LocalizedException $exception) {
            throw new CouldNotSaveException(
                __('Could not save the question: %1', $exception->getMessage()),
                $exception
            );
        } catch (\Throwable $exception) {
            throw new CouldNotSaveException(
                __('Could not save the question: %1', __('Something went wrong while saving the question.')),
                $exception
            );
        }
        return $question;
    }

    /**
     * Load Question data by given Question Identity
     *
     * @param string $questionId
     * @return Question
     * @throws NoSuchEntityException
     */
    public function getById($questionId)
    {
        $question = $this->questionFactory->create();
        $question->load($questionId);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('The FAQ question with the "%1" ID doesn\'t exist.', $questionId));
        }

        return $question;
    }

    /**
     * Load question data collection by given search criteria
     *
     * @param SearchCriteriaInterface $criteria
     * @return QuestionSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $criteria)
    {
        $collection = $this->questionCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();

        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Delete Question
     *
     * @param QuestionInterface $question
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(QuestionInterface $question)
    {
        try {
            $this->resource->delete($question);
            $this->identityMap->remove($question->getId());
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the question: %1', $exception->getMessage())
            );
        }
        return true;
    }

    /**
     * Delete Question by given Question Identity
     *
     * @param string $questionId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($questionId)
    {
        return $this->delete($this->getById($questionId));
    }
}
