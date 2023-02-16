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
namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Magebit\Faq\Api\QuestionRepositoryInterface as QuestionRepository;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;

/**
 * faq page grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    /**
     * @var \Magebit\Faq\Api\QuestionRepositoryInterface
     */
    protected $questionRepository;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $jsonFactory;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context           $context,
        QuestionRepository    $questionRepository,
        JsonFactory       $jsonFactory
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * Process the request
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);

        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData(
                [
                    'messages' => [__('Please correct the data sent.')],
                    'error' => true,
                ]
            );
        }

        foreach (array_keys($postItems) as $questionId) {
            /** @var \Magebit\Faq\Model\Question $question */
            $question = $this->questionRepository->getById($questionId);
            try {
                $extendedQuestionData = $question->getData();
                $this->setFaqQuestionData($question, $extendedQuestionData, $postItems);
                $this->questionRepository->save($question);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $e->getMessage();
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $e->getMessage();
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $e->getMessage();
                $error = true;
            }
        }

        return $resultJson->setData(
            [
                'messages' => $messages,
                'error' => $error
            ]
        );
    }

    /**
     * Set FAQ question data
     *
     * @param \Magebit\Faq\Model\Question $question
     * @param array $extendedQuestionData
     * @param array $questionData
     * @return $this
     */
    public function setFaqQuestionData(\Magebit\Faq\Model\Question $question, array $extendedQuestionData, array $questionData)
    {
        try {
            $question->setData(array_merge($question->getData(), $extendedQuestionData, $questionData[$question->getData()['id']]));
        } catch (\Exception $e) {
            $messages[] = $e->getMessage();
            $error = true;
        }
        return $this;
    }
}
