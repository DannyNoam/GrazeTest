<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Controller class for Graze PHP Test. Index
* method is called when user visits appropriate
* URL, specific to CodeIgniter configuration.
*
* @author Danny Noam <dn79@sussex.ac.uk>
*/

class account extends CI_Controller
{
	var $account_ratings;
	var $account_boxes;
	var $accNumber;

	/**
	* Constructs the class and parent class.
	*/
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('account_model');
    }
	
	/**
	* When a user visits the appropriate URL, function
	* is called. Gets user input, and makes appropriate
	* calls to account model.
	*/
	function index()
    {
		$this->accNumber = $this->input->get('accNumber');
		$data['accNumber'] = $this->accNumber;
		
		// Load header template
		$this->load->view("templates/header", $data);
		
		// Perform queries to get account ratings/boxes
		$this->account_ratings = $this->account_model->getAccountRatings($this->accNumber);
		$this->account_boxes = $this->account_model->getAccountBoxes($this->accNumber);
		
		// Main method; grabs all boxes and their data from account history
		$this->get_account_box_history();
    }
	
	/**
	* Iteratively goes through account and lists
	* all boxes purchased, and their contents.
	*/
	function get_account_box_history()
	{
		// Iterate through boxes
		for($i = 0; $i < count($this->account_boxes); $i++)
		{	
			// Get product IDs for given box
			$boxes_to_products_array = $this->account_model->getBoxProductIDs($this->account_boxes[$i]['id']);
			
			// Load box view template
			$data['boxID'] = $this->account_boxes[$i]['id'];
			$data['accNumber'] = $this->accNumber;
			$this->load->view('templates/grazeBox', $data);
			
			// Get product IDs from boxes
			for($j = 0; $j < count($boxes_to_products_array); $j++) // Always 4 products in data-set
			{
				// Get product ID and image URL
				$productID = $boxes_to_products_array[$j]['product_id'];
				$productImage = $this->account_model->getProductImageURL($productID);
				$productName = $this->account_model->getProductName($productID);
				$productRating = $this->account_model->getProductRating($productID, $this->accNumber);
				$productCategory = $this->account_model->getProductCategory($productID);
				
				// Load box view template 
				$data['productID'] = $productID;
				$data['imageURL'] = $productImage;
				$data['productName'] = $productName;
				$data['productRating'] = $productRating;
				$data['productCategory'] = $productCategory;
				$this->load->view('templates/boxContents', $data);
			}
			// Closing div tag
			$this->load->view('templates/closeDiv');
		}
	}
	
	/**
	* Allows a user to change the rating
	* of a specified product
	*/
	function changeRating()
	{
		// Get input
		$new_rating = $this->input->post('rating');
		$productID = $this->input->post('productID');
		$accNumber = $this->input->post('accNumber');
		
		// Make call to change rating
		$this->account_model->modifyRating($accNumber, $productID, $new_rating);
		
		// Load basic 'rating changed' view
		$this->load->view('ratingChanged');
	}
}

