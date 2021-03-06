<?php
/**
 * Shopware 4.0 - Dispatch
 * Copyright © 2012 shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Shopware_Models
 * @subpackage Backend, Newsletter
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author     Daniel Nögel
 * @author     $Author$
 */

namespace   Shopware\Models\Newsletter;
use         Shopware\Components\Model\ModelEntity,
            Doctrine\ORM\Mapping AS ORM;

/**
 * Shopware Address model represents a mail address.
 *
 * @ORM\Entity(repositoryClass="Repository")
 * @ORM\Table(name="s_campaigns_mailaddresses")
 */
class Address extends ModelEntity
{
    /**
     * Autoincrement ID
     *
     * @var integer $id
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Does this address belong to a customer?
     *
     * @var boolean $isCustomer
     *
     * @ORM\Column(name="customer", type="boolean", nullable=false)
     */
    private $isCustomer;

    /**
     * ID of the newsletter-group this mail address belongs to
     *
     * @var integer $groupId
     *
     * @ORM\Column(name="groupID", type="integer", length=11, nullable=true)
     */
    private $groupId = 0;

    /**
     * The actual email address
     *
     * @var string $email
     * @ORM\Column(name="email", type="string", length=90, nullable=false)
     */
    private $email;

    /**
     * OWNING SIDE
     * The customer property is the owning side of the association between customer and newsletter address.
     * The association is joined over the newsletter mail address and the customer mail address
     *
     * @ORM\OneToOne(targetEntity="Shopware\Models\Customer\Customer")
     * @ORM\JoinColumn(name="email", referencedColumnName="email")
     * @var \Shopware\Models\Customer\Customer
     */
    protected $customer;

    /**
     * OWNING SIDE
     * The group property is the owning side of the association between group and newsletter group
     * The association is joined over the address groupId and the group's id
     *
     * @ORM\OneToOne(targetEntity="Shopware\Models\Newsletter\Group")
     * @ORM\JoinColumn(name="groupID", referencedColumnName="id")
     * @var \Shopware\Models\Newsletter\Group
     */
    protected $newsletterGroup;

    /**
     * ID of the last newsletter this user received
     *
     * @var integer $lastNewsletter
     * @ORM\Column(name="lastmailing", type="integer", length=11, nullable=false)
     */
    private $lastNewsletterId = 0;

    /**
     * OWNING SIDE
     * The lastNewsletter property is the owning side of the association between a newsletter and a mail-address
     * The association is joined over the lastNewletterId and Newsletter.id
     *
     * @ORM\ManyToOne(targetEntity="Shopware\Models\Newsletter\Newsletter", inversedBy="addresses")
     * @ORM\JoinColumn(name="lastmailing", referencedColumnName="id")
     * @var \Shopware\Models\Newsletter\Newsletter
     */
    private $lastNewsletter;

    /**
     * ID of the last mailing this user read
     *
     * @var integer $lastReadId
     * @ORM\Column(name="lastread", type="integer", length=11, nullable=false)
     */
    private $lastReadId = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param boolean $isCustomer
     */
    public function setIsCustomer($isCustomer)
    {
        $this->isCustomer = $isCustomer;
    }

    /**
     * @return boolean
     */
    public function getIsCustomer()
    {
        return $this->isCustomer;
    }

    /**
     * @param int $lastMailingId
     */
    public function setLastMailingId($lastMailingId)
    {
        $this->lastMailingId = $lastMailingId;
    }

    /**
     * @return int
     */
    public function getLastMailingId()
    {
        return $this->lastMailingId;
    }

    /**
     * @param int $lastReadId
     */
    public function setLastReadId($lastReadId)
    {
        $this->lastReadId = $lastReadId;
    }

    /**
     * @return int
     */
    public function getLastReadId()
    {
        return $this->lastReadId;
    }

    /**
     * @param \Shopware\Models\Newsletter\Group $group
     */
    public function setNewsletterGroup($newsletterGroup)
    {
        $this->newsletterGroup = $newsletterGroup;

        return $this;
    }

    /**
     * @return \Shopware\Models\Newsletter\Group
     */
    public function getNewsletterGroup()
    {
        return $this->newsletterGroup;
    }

    /**
     * @param int $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return int
     */
    public function getGroupId()
    {
        return $this->groupId;
    }
}

