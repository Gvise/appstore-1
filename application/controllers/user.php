<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	}
	
   protected function checkLogin(){
	    if((strlen($this->session->userdata('user')) == 0) && ($this->session->userdata('user_id') == 0)){
	       $message ="Access denied! please login to access";
	       $this->session->set_flashdata('invalidaccess', $message); 
	       redirect('user/login'); 
	    }
	}
	
	public function home()
	{
		$this->checkLogin();
	    $this->get_dashboard();	
			
	}
	
	
	public function register()
	{
		$data = array();
		
		if($this->input->post('register') == 'Register') {
			
			if($this->form_validation->run()) {
				$this->load->library('user_service');
				$this->user_service->create($this->input);
			}
		}
		
		$data['content'] = $this->load->view("user/register", $data, true);
		$this->load->view("template/main", $data);
		
	}
	
	private function get_dashboard()
	{
		$this->checkLogin();
		
	    $data = array();
		
		switch ($userType) {
			case "admin";
				$data['content'] = $this->load->view("user/admin/dashboard", $data, true);
				break;			
			default:
				
		}
		
		
		$this->load->view("template/main", $data);
		
		
	}
	
	public function test()
	{
		
		$userService = new \Services\User();
		
		var_dump($userService);
	}
	
	public function login()
	{
	
	    $data = array();
	    
			
		if(is_array($this->input->post()) && $this->input->post('Login') == 'Login') {
                   	// submitting
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
		    
		    if ($this->form_validation->run() == FALSE)
		    {
		      $data['content'] = $this->load->view('user/login', $data, true);
		      $this->load->view('template/main', $data); 
		       
		    }else{
		    // success
				$userService = new \Services\User();
                                
				try{
				    
				    $user = $userService->login(array("name" => $this->input->post('username'), "password" => md5($this->input->post('password'))));
					if($user[0]) {
					   
						$this->session->set_userdata(array("user" => $user[0]->getName(), "user_id" => $user[0]->getId()));
						
    					if($this->input->post('username') == 'admin'){
                		    redirect('admin'); 
    		             }else{
                            redirect('application');
    		             }
						
						// redirect!
					}
				}catch(Exception $e) {
					$data['message'] = $e->getMessage();
					$data['content'] = $this->load->view('user/login', $data, true);
		            $this->load->view('template/main', $data); 
				}
		    }	
					
		}else{
		    $data['content'] = $this->load->view('user/login', $data, true);
		    $this->load->view('template/main', $data); 
		}
		
	}
	
                
    
	public function logout()
	{
	    $this->session->unset_userdata('user');
		$this->session->unset_userdata('user_id');				
	    redirect('user/login');
	}
	
	public function dashboard()
	{
		$this->checkLogin();
	    $data['content'] = '';
		$this->load->view('user/admin/dashboard',$data);
	}
    
}