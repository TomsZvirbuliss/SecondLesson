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

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template\Context;

/**
 * Block responsible for displaying list of CMS pages
 */
class PageList extends Template implements BlockInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $cmsPageRepository;

    /**
     * @var $searchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var Context
     */
    private $context;

    /**
     * @var UrlInterface
     */
    public $urlBuilder;


    /**
     *
     * Initialization
     *
     * @param PageRepositoryInterface $cmsPageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Context $context
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        PageRepositoryInterface $cmsPageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Context $context,
        UrlInterface $urlBuilder,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->urlBuilder = $urlBuilder;
        $this->cmsPageRepository = $cmsPageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Returns widget title and pages
     *
     * @return array
     */
    public function getInformation(): array
    {
        $data = array();
        $rawPages = $this->getData('selected_page');
        if (gettype($rawPages) == 'string') {
            $this->searchCriteriaBuilder->addFilter('identifier', $rawPages, 'in');
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $data['pages'] = $this->cmsPageRepository->getList($searchCriteria)->getItems();
        } else {
            $this->searchCriteria = $this->searchCriteriaBuilder->create();
            $data['pages'] = $this->pages = $this->cmsPageRepository->getList($this->searchCriteria)->getItems();
        }
        $data['title'] = $this->getData('title');
        return $data;
    }

    protected $_template = "/page-list.phtml";
}
