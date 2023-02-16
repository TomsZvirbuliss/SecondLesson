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

use Magento\Framework\App\Action\HttpPostActionInterface;

/**
 * Delete FAQ question action.
 */
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            $question = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Magebit\Faq\Model\Question::class);
                $model->load($id);

                $question = $model->getQuestion();
                $model->delete();

                // display success message
                $this->messageManager->addSuccessMessage(__('The question has been deleted.'));

                // go to grid
                $this->_eventManager->dispatch('adminhtml_faqquestion_on_delete', [
                    'question' => $question,
                    'status' => 'success'
                ]);

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->_eventManager->dispatch(
                    'adminhtml_faqquestion_on_delete',
                    ['question' => $question, 'status' => 'fail']
                );
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a page to delete.'));

        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
