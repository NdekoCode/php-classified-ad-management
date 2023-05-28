<?php

namespace App\Models;

class AnnoncesModel extends Model
{
    protected int|string $id;
    protected string $title;
    protected string $slug;
    protected string $description;
    protected string $createdAt;
    protected bool | int $active;

    protected array $fillable = ['title', 'description', 'slug', 'createdAt', 'active'];

    protected $verifyFields = ['id', 'title', 'description', 'slug'];
    public function __construct()
    {
        parent::__construct();
        $this->table = 'annonces';
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {

        $this->title = $title;
        $this->setSlug($title);
        return $this;
    }

    /**
     * Get the value of slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of active
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get fillable data it means the data to be modified
     *
     * @return  array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Set fillable data it means the data to be modified
     *
     * @param  array  $fillable  Fillable data it means the data to be modified
     *
     * @return  self
     */
    public function setFillable(array $fillable)
    {
        $this->fillable = $fillable;

        return $this;
    }
}
