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
declare(strict_types=1);

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\QuestionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Save FAQ question action.
 */
class Save extends Action implements HttpPostActionInterface
{


    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var QuestionFactory
     */
    private $questionFactory;

    /**
     * @var QuestionRepositoryInterface
     */
    private $questionRepository;

    /**
     * @param Action\Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param QuestionFactory $questionFactory
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        QuestionFactory $questionFactory,
        QuestionRepositoryInterface $questionRepository
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->questionFactory = $questionFactory;
        $this->questionRepository = $questionRepository;
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Question::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            /** @var Question $model */
            $model = $this->questionFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->questionRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This page no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            $model->setData($data);
            try {
                $this->questionRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the question.'));
                return $this->processResultRedirect($model, $resultRedirect, $data);
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Throwable $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving the question.'));
            }

            $this->dataPersistor->set('faq_question', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process result redirect
     *
     * @param QuestionInterface $model
     * @param Redirect $resultRedirect
     * @param array $data
     * @return Redirect
     * @throws LocalizedException
     */
    private function processResultRedirect($model, $resultRedirect, $data)
    {
        if ($this->getRequest()->getParam('back', false) === 'duplicate') {
            $newQuestion = $this->questionFactory->create(['data' => $data]);
            $newQuestion->setId(null);
            $identifier = $model->getIdentifier() . '-' . uniqid();
            $newQuestion->setIdentifier($identifier);
            $newQuestion->setIsActive(false);
            $this->questionRepository->save($newQuestion);
            $this->messageManager->addSuccessMessage(__('You duplicated the page.'));
            return $resultRedirect->setPath(
                '*/*/edit',
                [
                    'id' => $newQuestion->getId(),
                    '_current' => true,
                ]
            );
        }
        $this->dataPersistor->clear('faq_question');
        if ($this->getRequest()->getParam('back')) {
            return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
