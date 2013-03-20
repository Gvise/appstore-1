<?php
/**
 * 
 * @author Prasanth
 * @package \Services
 * @since 
 * @version 1.0
 */
namespace Services;

/**
 * Product service
 * @author Prasanth
 *
 */
class Product extends \Services\BaseService
{
	/**
	 * Create a product
	 * 
	 * @param array $data
	 * @return int
	 */
	public function create($data)
	{
		$categoryService = new \Services\Category();
		
	
		$brandService = new \Services\Brand();
		$userService = new \Services\User();
		
		$customer = $userService->findById($data->post('customer'));
		$product = new \Entities\Product();
		$product->setName($data->post('name'));
		$product->setBrand($brandService->findById($data->post('brand')));
		$product->setUser($customer);
		$product->addCategory($categoryService->findById($data->post('category')));
		$product->setDescription($data->post('desc'));
		$product->setPrice($data->post('lowest_price'));
		$product->setStrikeNowPrice($data->post('strikenow_price'));
		if($data->post('size') != "") {
			$product->setSize($data->post('size'));
		}
		$product->setColor($data->post('color'));
		if($data->post('condition') != "") {
			$product->setCondition($data->post('condition'));
		}
		
		$product->setStatus('Afventer');
		$product->setCreatedDate(new \DateTime());
	
		$product->setActive(1);
		
		$this->save($product);
		
		// create notification
		$notification['message'] = "Your product <strong>". $product->getName(). "</strong> has been created. <a href='". site_url('product/display/'. $product->getId()) ."'>Verify</a> the product to list.";
		$notification['user'] = $customer;
		
		$notificationService = new \Services\User\Notification();
		$notificationService->createNotification($notification);
		
		return $product->getId();
	}
	
	/**
	 * Function to update teh product
	 * 
	 * @param array $data
	 * @param \Entities\Product $product
	 */
	public function updateProduct($data, $product)
	{

		$categoryService = new \Services\Category();
	
		
		$brandService = new \Services\Brand();
	
		$userService = new \Services\User();
		
		if($data->post('customer')) {
			$customer = $userService->findById($data->post('customer'));
			$product->setUser($customer);
		}
		
		$product->setName($data->post('name'));
		$product->setBrand($brandService->findById($data->post('brand')));
		
		$existingCategories = $product->getCategories();

		//since we are only using one category, fetch that
		$existingCategory = $existingCategories[0];
		
		$newCategory = $categoryService->findById($data->post('category'));
		
		if(!($newCategory === $existingCategory)) {
			$product->removeCategory($existingCategory);
			
			// add the new one
			
			$product->addCategory($newCategory);
		}
		$product->setDescription($data->post('desc'));
		
		if($data->post('lowest_price')) {
			$product->setPrice($data->post('lowest_price'));
		}
		if($data->post('strikenow_price')) {
			$product->setStrikeNowPrice($data->post('strikenow_price'));
		}
		$product->setSize($data->post('size'));
		$product->setColor($data->post('color'));
		$product->setCondition($data->post('condition'));
		
		
		$this->save($product);
		
		
		return $product->getId();
	}
	
	
	/** 
	 * Persist  the data to the storage
	 * @param \Entities\User $user
	 */
	private function save(\Entities\Product $product)
	{
		$this->em->persist($product);
		$this->em->flush();
	
	}
	
	/**
	 * Find the product based on a criteria given
	 * @param array $criteria
	 * @return array|null
	 */
	public function find()
	{
		
		return $this->em->getRepository('\Entities\Product')->findAll();
	}
	
	/**
	 * Find a product based on the primary key, id
	 * @param int $id
	 * @return \Entities\Product | null
	 */
	public function findById($id)
	{
	
		return $this->em->getRepository('\Entities\Product')->findOneById($id);
	}
	
	/**
	 * Fetch the images associated with a product
	 * 
	 * @param int $id
	 * @return array | null
	 */
	public function getimages($id)
	{
		$product = $this->findById($id);
		
		if($product) {
			return $product->getImages();
		}else {
			return null;
		}
	}
	
	/**
	 * Function to update the product by the seller
	 * @param array $data
	 */
	public function update($data)
	{
	
		if($data->post('product') > 0) {
				
			$product = $this->findById($data->post('product') );
			if($data->post('existing') != 1) {
	
				if($data->post('lowest_price') > 0) {
					
					$product->setPrice($data->post('lowest_price'));
				
				}
				if($data->post('strikenow_price') > 0) {
						
					$product->setStrikeNowPrice($data->post('strikenow_price'));
				
				}
				if($data->post('charity') == 1) {
	
					$product->setCharity($data->post('charity'));
				}
			}
				
			$product->setPublished(true);
			$product->setPublishedDate(new \DateTime);
			$product->setStatus('Aktiv');
			$notificationService = new \Services\User\Notification();
			
			$notification['message'] = "<a href='". site_url('product/display/'. $product->getId()) ."'>" . $product->getName(). "</a> has been published by <a href='". site_url('user/view/'. $product->getUser()->getId()) ."'>".  $product->getUser()->getDetails()->getName(). "</a>"; 
			
			$userService = new \Services\User();			
			$admin = $userService->findById(1);
			
			$notification['user'] = $admin;
			
			$notificationService->createNotification($notification);
			
			
			$this->save($product);
				
		}else {
			// throw error
		}
	}
	
	/**
	 * Fetch the products for the front end.
	 * 
	 * @param array $criteria
	 * @return array | null
	 */
	public function getAll()
	{
		
		return $this->find();
	}
	
	public function findProducts($criteria = null,$page = 1, $count = 20, $sort = null, $orderBy="")
	{
		$criteria['published'] = true;
		return $this->em->getRepository('\Entities\Product')->findProducts($criteria, $page, $count, $sort, $orderBy);
		
		
		
	}
	
    public function addProduct($data){
        
        if(isset($data['postdata']['productId']) && $data['postdata']['productId'] > 0){
           
            $productobj = $this->findById($data['postdata']['productId']);
        } else{
            $productobj = new \Entities\Product();
        }
         
        $categoryService = new \Services\Category();
        
        if(strlen($data['postdata']['name']) > 0){
          $productobj->setName($data['postdata']['name']);  
        }
       
       
        if(strlen($data['postdata']['desc']) > 0){
          $productobj->setDescription($data['postdata']['desc']);
        }
        
               
        if($data['postdata']['price'] > 0){ 
          $productobj->setPrice($data['postdata']['price']);  
        }
         
        if(strlen($data['postdata']['publisheddate']) > 0){
            $date = new \DateTime($data['postdata']['publisheddate']);
            $productobj->setPublishedDate($date);
        }
        
        if(isset($data['filedata']['upload_data']['file_name']) && strlen($data['filedata']['upload_data']['file_name']) > 0){
          $productobj->setImageName($data['filedata']['upload_data']['file_name']);  
        }
        
        if($data['postdata']['version'] > 0){
            $productobj->setVersion($data['postdata']['version']);
        }
        
       
        
        if($data['postdata']['category'] > 0){
          
            if(isset($data['postdata']['productId']) && $data['postdata']['productId'] > 0){
                foreach($productobj->getCategories() as $value)
                {
                    $productobj->removeCategory($categoryService->findById($value->getId())); 
                }      
            }
          
          $productobj->addCategory($categoryService->findById($data['postdata']['category']));   
        }  
        
       
        if(!isset($data['postdata']['productId'])){
                       
            $cutdate = new \DateTime();
            $productobj->setCreatedDate($cutdate);
             
            $productobj->setActive('1');
            $productobj->setPublished('0');  
        }
        
        $this->saveProduct($productobj);            
            
	}
	
	
	/** 
	 * Persist  the data to the storage
	 * 
	 * @param \Entities\Product $product
	 */
	public function saveProduct($product)
	{
	   
	    try {
              $this->em->persist($product);
		      $this->em->flush();
              return true;
        } catch(\Exception $e) {
            echo "Error while persisting". $e->getMessage();
            return false;
        }
		
	}
	
	/**
	 * Delete the product
	 * 
	 * @author: Prabhash
	 * @param $id
	 */
	public function deleteProduct($id)
	{
	    $product = $this->findById($id);
	        
    	try {
                 $this->em->remove($product);
    		     $this->em->flush();
                 return true;
            } catch(\Exception $e) {
                echo "Error while removing it.". $e->getMessage();
                return false;
            }
	    
	}
	
	
	/**
	 * Function to add the product to cart
	 *
	 * @param integer $id
	 * @throws \Exception
	 * @throws \Exception
	 */
	public function addToCart($id)
	{
	
		$productService = new \Services\Product();
	
		$product = $productService->findById($id);
	
		if($product) {
			$cartItem = array(
					'id'	=> $product->getId(),
					'name'	=> $product->getName(),
					'qty'   => 1,
					'price' => $product->getStrikeNowPrice()
			);
			try{
				$this->ci->cart->insert($cartItem);
			}catch(\Exception $e) {
				throw $e;
			}
				
		}else {
			throw new \Exception("Product not found");
		}
	
	}
	
	public function changeStatus(\Entities\Product $product, $status)
	{
		$product->setStatus($status);
		
		if($status == "Solgt") {
			$product->setSoldDate(new \DateTime);
			$product->setBidEndDate(null);
		}
		
		try{
			$this->save($product);
			
			
		}catch(\Exception $e) {
			
		}
		
		
	}
	
	public function updateBidDetails($bidDetails)
	{
		
		
		$product = $bidDetails['product'];
		$minimumBid = $product->getMinimumBid();
		if($minimumBid < $bidDetails['bid']) {
			$product->setMinimumBid($bidDetails['bid']);
			
			
		
			if($minimumBid == 0 || $minimumBid == "") {
				$product->setStatus('Bud');
			}
			
			if($bidDetails['bid'] >= $product->getPrice()) {
				$product->setBidStartDate(new \DateTime);
				$endDate = clone ($product->getBidStartDate());
				$endDate->add(new \DateInterval('PT48H'));
				$product->setBidEndDate($endDate);
			}
			
			$this->save($product);
		}
		
	}
	
	public function getTotalRecords()
	{
		$result = $this->em
			->createQueryBuilder()
			->select('count(p.id) as cnt')
			->from('\Entities\Product', 'p')
			->getQuery()
			->getResult();

		if(is_array($result) && !empty($result))
		{
			return $result[0]['cnt'];
		}
		
		return 0;
	}
}