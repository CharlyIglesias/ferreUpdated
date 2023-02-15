<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface as ObjectManager;


use App\Entity\Product;
use App\Entity\Family;
use App\Entity\Brand;
use App\Entity\FamilyProductRelation;
use App\Entity\BrandProductRelation;

class ProductService
{
    protected $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function getAllProducts(){
        return $this->om->getRepository(Product::class)->findAll();
    }
    public function getProductById($id){
        return $this->om->getRepository(Product::class)->find($id);
    }
    
    public function getAllFamilies(){
        return $this->om->getRepository(Family::class)->findAll();
    }
    public function getFamilyById($id){
        return $this->om->getRepository(Family::class)->find($id);
    }

    public function getFamiliesByProduct($product){
        return $this->om->getRepository(FamilyProductRelation::class)->findBy(['product' => $product]);
    }
    public function getAllBrands(){
        return $this->om->getRepository(Brand::class)->findAll();
    }
    public function getBrandById($id){
        return $this->om->getRepository(Brand::class)->find($id);
    }
    public function getBrandsByProduct($product){
        return $this->om->getRepository(BrandProductRelation::class)->findBy(['product' => $product]);
    }
    public function createProduct($form){
        $product = new Product();
        $product->setName($form->getName());
        $product->setDescription($form->getDescription());
        $product->setImageLink($form->getImageLink());
        $product->setInStock($form->getInStock());
        $product->setCreationDate(new \DateTime());
        $this->om->persist($product);
        $this->om->flush();

        return $product;
    }
    public function editProduct($id, $form){
        $product = $this->getProductById($id);
        $product->setName($form->getName());
        $product->setDescription($form->getDescription());
        $product->setImageLink($form->getImageLink());
        $product->setInStock($form->getInStock());
        $product->setLastUpdateDate(new \DateTime());

        $this->om->persist($product);
        $this->om->flush();

        return $product;
    }

    public function addFamiliesToProduct($product, $families, $newFamiliesName){

        $oldFamilies = $this->getFamiliesByProduct($product);
        foreach($oldFamilies as $oldFamily){
            $this->om->remove($oldFamily);
            $this->om->flush();
        }

        foreach($families as $familyId){
            $family = $this->getFamilyById($familyId);
            if($family == null || empty($family)){
                $index = array_search($familyId, $families);
                $family = new Family();
                $family->setName($newFamiliesName[$index]);
                $this->om->persist($family);
                $this->om->flush();
            }
            $familyRelation = new FamilyProductRelation();
            $familyRelation->setFamily($family);
            $familyRelation->setProduct($product);
            $this->om->persist($familyRelation);
            $this->om->flush();
        }
    }
    public function addBrandsToProduct($product, $brands, $newBrandsName){

        $oldBrands = $this->getBrandsByProduct($product);
        foreach($oldBrands as $oldBrand){
            $this->om->remove($oldBrand);
            $this->om->flush();
        }
        foreach($brands as $brandId){
            $brand = $this->getBrandById($brandId);
            if($brand == null || empty($brand)){
                $index = array_search($brandId, $brands);
                $brand = new brand();
                $brand->setName($newBrandsName[$index]);
                $this->om->persist($brand);
                $this->om->flush();
            }
            $brandRelation = new BrandProductRelation();
            $brandRelation->setbrand($brand);
            $brandRelation->setProduct($product);
            $this->om->persist($brandRelation);
            $this->om->flush();
        }
    }

    public function getLastProduct($quantity){
        $qb = $this->om->getRepository(Product::class)->createQueryBuilder('p')
        ->orderBY('p.creationDate', 'DESC')
        ->setMaxResults($quantity);
        $query = $qb->getQuery();
        $results = $query->getResult();
        return $results;
    }

    public function filterProducts($familia, $brandArr, $name){
        $queryBuilder = $this->om->getRepository(Product::class)->createQueryBuilder('p')
            ->where("p.id > 0");

        if($name != ''){
            $queryBuilder
            ->andWhere("LOWER(p.name) LIKE :name OR LOWER(p.description) LIKE :name")
            ->setParameter("name", '%'.$name.'%');
        }    

        if($familia != null && !empty($familia)){
            $queryBuilder->join('p.familyProductRelations', 'fpr')
            ->andWhere("fpr.family = :family")
            ->setParameter("family", $familia['id']);
        }
        $marcas = [];
        if($brandArr != '' && !empty($brandArr)){
            foreach($brandArr as $brand){
                if($brand['id'] > 0){
                    $marcas[] = $this->om->getRepository(Brand::class)->find($brand['id']);
                }
            }
        }
        if($marcas){
            $queryBuilder->join('p.brandProductRelations', 'bpr')
            ->andWhere("bpr.brand IN (:marcas)")
            ->setParameter("marcas", $marcas);
        }
        $query = $queryBuilder->getQuery();
        return $query->execute();
    }

    public function getDescriptionInArray($product){
        $descriptionExploded = explode('-',trim($product->getDescription()));
        if(count($descriptionExploded) > 1){
            $descriptionNueva = [];
            for($i=0; $i<count($descriptionExploded); $i++){
                if($descriptionExploded[$i] != ''){
                    $descriptionText = trim($descriptionExploded[$i]);
                    $descriptionNueva[$i] = $descriptionText;
                }
            }
            return $descriptionNueva;
        }
        $descriptionNueva[0] = $product->getDescription();
        return $descriptionNueva;
    }
}
