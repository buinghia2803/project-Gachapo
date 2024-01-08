<?php

namespace App\Business;

use App\Helpers\UploadHelper;

/**
 * Class BaseBusiness
 * @package App\Business
 */
class BaseBusiness
{
    protected $repository;

    /**
     * BaseBusiness constructor.
     * @param $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create
     *
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        return $this->repository->create($input);
    }

    /**
     * Find by Id
     *
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * Find
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Update
     *
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input)
    {
        return $this->repository->updateById($id, $input);
    }

    /**
     * Delete
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Get all
     *
     * @param array $search
     * @param null $skip
     * @param null $limit
     * @param string[] $columns
     * @return mixed
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        return $this->repository->all($search, $skip, $limit, $columns);
    }

    public function getList(
        array $conditions = [],
        array $relations = [],
        int $perPage = DEFAULT_PER_PAGE,
        string $orderedField = '',
        string $typeSort = DESC
    ) {
        return $this->repository->getList($conditions, $relations, $perPage, $orderedField, $typeSort);
    }


    /**
     * Get list.
     *
     * @param  mixed $conditions
     *
     * @return  Collection $entities
     */
    public function list($conditions, $relations = [], $selectable = [], $relationCounts = [])
    {
        $list = $this->repository->list($conditions, $relations, $selectable, $relationCounts);
        return $list;
    }

    /**
     * Find by condition .
     *
     * @param mixed $request
     * @param array $relations
     *
     * @return object $entities
     */
    public function findByCondition($condition, $relations = [],  $selectable = [])
    {
        return $this->repository->findByCondition($condition, $relations, $selectable);
    }

    /**
     * Update model.
     *
     * @param Model $entity
     *
     * @return Boolean
     */
    public function destroy($entity)
    {
        return $this->repository->destroy($entity);
    }

    /**
     *
     *
     * @param base64_encode
     *
     * @return file url
     */
    public function uploadS3Base64($fileBase64)
    {
        $imageLink = "";
        $imageUrl = UploadHelper::doUploadS3Base64($fileBase64);

        if ($imageUrl) {
            $imageLink = UploadHelper::getUrlImage($imageUrl);
        }

        return $imageLink;
    }

    /**
     *
     *
     * @param url of file
     *
     * @return file url
     */
    public function destroyS3($path)
    {
        if ($path) {
            $filenames = explode("/", $path);
            $filename = $filenames[count($filenames) - 1];
            $filePath = 'images/' . $filename;
            UploadHelper::destroyS3($filePath);
        }
    }
}
