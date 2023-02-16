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
namespace Magebit\Faq\Model\ResourceModel\Question;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * FAQ model
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * @var string
     */
    protected $_eventPrefix = 'magebit_faq_question_collection';
    /**
     * @var string
     */
    protected $_eventObject = 'question_collection';

    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Magebit\Faq\Model\Question::class, \Magebit\Faq\Model\ResourceModel\Question::class);
        $this->_map['fields']['id'] = 'main_table.id';
    }

}
