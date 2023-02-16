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
namespace Magebit\Faq\Model\ResourceModel;
/**
 * FAQ model
 */
class Question extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     *
     * @param $context \Magento\Framework\Model\ResourceModel\Db\Context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * initializes database table data
     */
    protected function _construct()
    {
        $this->_init('faq', 'id');
    }
}
