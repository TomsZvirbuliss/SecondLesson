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
namespace Magebit\Faq\Ui\Component\Form\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class Delete
 */
class Delete implements ButtonProviderInterface
{
    /**
     * Construct
     *
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository,
    ) {
        $this->context = $context;
        $this->questionRepository = $questionRepository;
    }

    /**
     * Gets button data
     *
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getQuestionId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getUrl('*/*/delete', ['id' => $this->getQuestionId()]) . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }


    /**
     * Return Faq question ID
     *
     * @return int|null
     */
    public function getQuestionId()
    {
        try {
            return $this->questionRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
