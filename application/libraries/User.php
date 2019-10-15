<?php

namespace Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="user")
 */
class User
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $username;

    /**
     * @Column(type="string", length=64, nullable=false)
     */
    protected $password;

    /**
     * @Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $email;

    /**
     * The @JoinColumn is not necessary in this example. When you do not specify
     * a @JoinColumn annotation, Doctrine will intelligently determine the join
     * column based on the entity class name and primary key.
     *
     * @ManyToOne(targetEntity="Group")
     * @JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;
}

/**
 * @Entity
 * @Table(name="group")
 */
class Group
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $name;

    /**
     * @OneToMany(targetEntity="User", mappedBy="group")
     */
    protected $users;
}