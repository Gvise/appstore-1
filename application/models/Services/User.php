<?php
namespace Services;

/**
 * 
 * @author Prasanth
 *
 */

class User extends BaseService
{
	
	
	/** 
	 * @param integer $id
	 */
	public function findById($id)
	{
		return $this->em->getRepository('\Entities\User')->findOneById($id);
	}
	
	/**
	 * 
	 * @param array $data
	 * @throws \Exception
	 * @return \Entities\User
	 */
	public function login(array $data)
	{
			
		$user = $this->em->getRepository('Entities\User')->findBy($data);
               
		if($user) {
			// loggged in!
			//@todo do the session saving here!
			
			return $user;			
		} else {			
			throw new \Exception('Invalid Username or Password');
		}
	}
	
	/** 
	 * Persist  the data to the storage
	 * 
	 * @param \Entities\User $user
	 */
	public function save($app)
	{
	  try {
              $this->em->persist($app);
		      $this->em->flush();
              return true;
        } catch(\Exception $e) {
            echo "Error while persisting". $e->getMessage();
            return false;
        }
		
	}
	
		
}