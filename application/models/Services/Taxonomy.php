<?php
namespace Services;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author Prasanth
 *
 */
class Category extends \Services\BaseService
{
	
	/**
	 * 
	 * @param string $returnType
	 */
	
	public function findAll($returnType = 'objects')
	{
                
		$categories = $this->em->getRepository('Entities\Category')->findAll();
                

		//if($returnType == 'objects') {
			//return $categories;
		//}else {
			if($categories) {
				return $this->prepareArray($categories);
			}else{
				return null;
			}
		//}
	}
	
	/**
	 * 
	 * @param ArrayCollection $categories
	 */
	
	private function prepareArray(array $categories) 
	{
		//$categoryArray = array(''=>'Select category');
                $categoryArray = array();
		
		foreach($categories as $category) {
                   //print_r($category->getName());
			if($category->getParent()) {
				$categoryArray[$category->getParent()->getName()] [$category->getId()]= $category->getName();
			}else{
				//$parentName = $category->getName();
                                $categoryArray[$category->getName()] [$category->getId()]= $category->getName();
			}
		}
		//print_r($categoryArray);
		return $categoryArray;
	}
	
	
	public function getProducts($id)
	{
		$category = $this->findById($id);
		return $category->getProducts();
		
	}
	
	public function findById($id)
	{
		
		return $this->em->getRepository('Entities\Category')->findOneById($id);
	}
	
}