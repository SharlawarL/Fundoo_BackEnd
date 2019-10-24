<?php
// src/Notes.php

use Doctrine\ORM\Mapping as ORM;
/**
 * Notes
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /** 
     * @ORM\Id
     * @ORM\Column(name = "id", type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(name = "firstname",type="integer")
     * @ORM\GeneratedValue
     */
    protected $firstname;
    /**
     * @ORM\Column(name = "lastname",type="integer")
     * @ORM\GeneratedValue
     */
    protected $lastname;
    /** 
     * @ORM\Column(name = "email") 
     */
    protected $email;
    /** 
     * @ORM\Column(name = "password") 
     */
    protected $password;
    /** 
     * @ORM\Column(name = "email_verify") 
     */
    protected $email_verify;
    /** 
     * @ORM\Column(name = "photo",type="integer") 
     */
    protected $social;
    /** 
     * @ORM\Column(name = "is_trash",type="integer") 
     */
    protected $Firebase_token;
     /**
     * Set user_id
     *
     * @param string $user_id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
     /**
     * Get Note id
     *
     * @return integer $note_id
     */
    public function getNoteId()
    {
        return $this->note_id;
    }

     /**
     * Set user_id
     *
     * @param string $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

     /**
     * Get User id
     *
     * @return integer $user_id
     */
    public function getUserId()
    {
        return $this->user_id;
    }

     /**
     * Set title
     *
     * @param string $name
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

     /**
     * Get title
     *
     * @return integer $title
     */
    public function getTitle()
    {
        return $this->title;
    }

     /**
     * Set Notes
     *
     * @param string $Notes
     */
    public function setNotes($Notes)
    {
        $this->Notes = $Notes;
    }

     /**
     * Get Notes
     *
     * @return integer $Notes
     */
    public function getNotes()
    {
        return $this->Notes;
    }

     /**
     * Set reminder
     *
     * @param string $reminder
     */
    public function setReminder($reminder)
    {
        $this->reminder = $reminder;
    }

     /**
     * Get reminder
     *
     * @return integer $user_id
     */
    public function getReminder()
    {
        return $this->reminder;
    }

     /**
     * Set index_no
     *
     * @param string $index_no
     */
    public function setIndexNumber($index_no)
    {
        $this->index_no = $index_no;
    }

     /**
     * Get index_no
     *
     * @return integer $index_no
     */
    public function getIndexNumber()
    {
        return $this->index_no;
    }

     /**
     * Set trash
     *
     * @param integer $trash
     */
    public function setTrash($is_trash)
    {
        $this->is_trash = $is_trash;
    }

     /**
     * Get trash
     *
     * @return integer $trash
     */
    public function getTrash()
    {
        return $this->is_trash;
    }

     /**
     * Set Archive
     *
     * @param string $archive
     */
    public function setArchive($is_archive)
    {
        $this->is_archive = $is_archive;
    }

    /**
     * Get Archive
     *
     * @return integer $archive
     */
    public function getArchive()
    {
        return $this->is_archive;
    }

     /**
     * Set color
     *
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Get Color
     *
     * @return integer $color
     */
    public function getColor()
    {
        return $this->color;
    }
}