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

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Validator\HTML\WYSIWYGValidatorInterface;
use Magento\Backend\Model\Validator\UrlKey\CompositeUrlKey;

/**
 * FAQ Model
 *
 * @api
 * @since 100.0.2
 */
class Question extends AbstractModel implements QuestionInterface, IdentityInterface
{
    /**#@+
     * Page's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**#@-*/

    /**
     * FAQ question cache tag
     */
    const CACHE_TAG = 'faq_cache';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'magebit_faq_question';

    /**
     * @var WYSIWYGValidatorInterface
     */
    private $wysiwygValidator;

    /**
     * @var CompositeUrlKey
     */
    private $compositeUrlValidator;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     * @param WYSIWYGValidatorInterface|null $wysiwygValidator
     * @param CompositeUrlKey|null $compositeUrlValidator
     */
    public function __construct(
        \Magento\Framework\Model\Context                        $context,
        \Magento\Framework\Registry                             $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb           $resourceCollection = null,
        array                                                   $data = [],
        ?WYSIWYGValidatorInterface                              $wysiwygValidator = null,
        CompositeUrlKey                                         $compositeUrlValidator = null
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->wysiwygValidator = $wysiwygValidator;
        $this->compositeUrlValidator = $compositeUrlValidator;
    }

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Magebit\Faq\Model\ResourceModel\Question::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     *
     * Get question id
     *
     * @return int|null
     */
    public function getQuestionId(): ?int
    {
        return $this->getData(self::ID);
    }

    /**
     * Get question
     *
     * @return string|null
     */
    public function getQuestion(): ?string
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * Get answer
     *
     * @return string|null
     */
    public function getAnswer(): ?string
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * Get status
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Get position
     *
     * @return string|null
     */

    public function getPosition(): ?string
    {
        return $this->getData(self::POSITION);
    }

    /**
     * Get updated at
     *
     * @return string|null
     */

    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set question
     *
     * @param $question
     * @return QuestionInterface|Question
     */
    public function setQuestion($question)
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * Set answer
     *
     * @param $answer
     * @return QuestionInterface|Page
     */
    public function setAnswer($answer)
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * Set status
     *
     * @param $status
     * @return QuestionInterface|Page
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Set position
     *
     * @param $position
     * @return QuestionInterface|Page
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }
}
