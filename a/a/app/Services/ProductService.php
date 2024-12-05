<?php
namespace App\Services;

use App\Models\ProductImage;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Traits\HandleImage;

class ProductService
{
    use HandleImage;

    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    protected function insertImagesDes($value, $productId)
    {
        $images = json_decode($value);
        if(!empty($images)) {
            $imagesInsert = [];
            foreach ($images as $image) {
                $imagesInsert[] = [
                    'product_id' => $productId,
                    'path' => $image,
                ];
            }
            ProductImage::insert($imagesInsert);
        }
    }

    protected function deleteImagesDes($value)
    {
        $ids = json_decode($value);
        if(!empty($ids)) {
            ProductImage::whereIn('id', $ids)->delete();
        }
    }

    public function store($request)
    {
        $data = $request->all();
        $data['thumbnail'] = $this->storeImage($request);
        $product = $this->productRepository->create($data);
        $product->addCategories($request->category_ids);
        $this->insertImagesDes($data['image-multiple'], $product->id);

        return $product;
    }

    public function update($request, $id)
    {
        $data = $request->all();
        $product = $this->productRepository->find($id);
        $data['thumbnail'] = $this->updateImage($request, $product->thumbnail);
        $product->update($data);
        $product->syncCategories($request->category_ids);
        $this->insertImagesDes($data['image-multiple'], $product->id);
        $this->deleteImagesDes($data['image-id']);

        return $product;
    }

    public function paginate($perPage = 10)
    {
        return $this->productRepository->paginate($perPage);
    }

    public function findWithRelationship($id)
    {
        return $this->productRepository->findWithRelationship($id, ['categories', 'images']);
    }

    public function delete($id)
    {
        $product = $this->productRepository->find($id);
        $product->delete();
        $this->deleteImage($product->thumbnail);

        return $product;
    }

    public function getBestSeller($limit = 8)
    {
        return $this->productRepository->getByLimit($limit);
    }

    public function getNew($limit = 8)
    {
        $products = $this->productRepository->getByLimit($limit);
        return $products->filter(function ($product) {
            return now()->diffInDays($product->created_at) <= 4;
        });
    }

    public function getHotSales($limit = 8)
    {
        return $this->productRepository->getHotSales($limit);
    }

    public function getByCategorySlug($slugCategory)
    {
        $dataFilter = [];
        $dataFilter['brand'] = request()->brand;
        $dataFilter['name'] = request()->name;
        $dataFilter['sort'] = request()->sort;
        return $this->productRepository->getByCategorySlug($slugCategory, $dataFilter);
    }

    public function getIfHasCategory()
    {
        $dataFilter = [];
        $dataFilter['brand'] = request()->brand;
        $dataFilter['name'] = request()->name;
        $dataFilter['sort'] = request()->sort;

        return $this->productRepository->getIfHasCategory($dataFilter);
    }

    public function findBySlug($slug)
    {
        return $this->productRepository->findBySlug($slug) ?? abort(404);
    }

    public function getBrand()
    {
        return $this->productRepository->getBrand();
    }

    public function count()
    {
        return $this->productRepository->count();
    }
}
