<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Model class for Graze PHP Test. Functionality
* for all the necessary database calls.
*
* @author Danny Noam <dn79@sussex.ac.uk>
*/

class Account_model extends CI_Model
{
	
	/**
	* Constructs the class and parent class.
	*/
    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	
	/**
	* Returns an array of all the ratings
	* associated with an account.
	*
	* @param accNumber The account ID of the account.
	* @return array An array of all the ratings.
	*/
	function getAccountRatings($accNumber)
	{
		$query = $this->db->get_where('rating', array("account_id" => $accNumber));
		$this->ratings_array = $query->result_array();
		return $query->result_array();
	}
	
	/**
	* Returns an array of all the boxes
	* associated with an account.
	*
	* @param accNumber The account ID of the account.
	* @return array An array of all the boxes.
	*/
	function getAccountBoxes($accNumber)
	{
		$query = $this->db->get_where('box', array("account_id" => $accNumber));
		return $query->result_array();
	}
	
	/**
	* Returns the rating of a given product
	* associated with an account.
	*
	* @param productID The product ID.
	* @param accountID The account ID.
	* @return String The rating of the product.
	* If no rating exists, "No rating" is
	* returned.
	*/
	function getProductRating($productID, $accountID)
	{
		$query = $this->db->get_where('rating', array("product_id" => $productID, "account_id" => $accountID));
        $query_array = $query->result_array();
		if(!empty($query_array))
		{	
			return $query_array[0]['rating'];
		}
		else
		{
			return "No rating";
		}
	}
	
	/**
	* Returns the product name of a given product.
	*
	* @param productID The product ID.
	* @return String The name of the product.
	*/
	function getProductName($productID)
	{
		$query = $this->db->get_where('product', array("id" => $productID));
        $query_array = $query->result_array();
		return $query_array[0]['name'];
	}
	
	/**
	* Returns the product image URL of a given product.
	*
	* @param productID The product ID.
	* @return array The product image URL.
	*/
	function getProductImageURL($productID)
	{
		$query = $this->db->get_where('product', array("id" => $productID));
        $query_array = $query->result_array();
		return $query_array[0]['image_url'];
	}
	
	/**
	* Returns the product category of a given product.
	*
	* @param productID The product ID.
	* @return array The product category.
	*/
	function getProductCategory($productID)
	{
		$query = $this->db->get_where('product', array("id" => $productID));
        $query_array = $query->result_array();
		return $query_array[0]['category'];
	}
	
	/**
	* Returns an array of all the product IDs associated
	* with a box ID.
	*
	* @param accNumber The box ID.
	* @return array An array of all the product IDs (always 4).
	*/
	function getBoxProductIDs($boxID)
	{
		$query = $this->db->get_where('box_to_product', array("box_id" => $boxID));
		return $query->result_array();
	}
	
	/**
	* Modifies the rating of a given product for a customer.
	* If no rating exists, one is inserted into DB.
	*
	* @param accountNum The account ID.
	* @param productID The product ID.
	* @param rating The new rating.
	*/
	function modifyRating($accountNum, $productID, $rating)
	{
		if(($this->getProductRating($productID, $accountNum) == "No rating"))
		{
			$query = $this->db->query("INSERT INTO rating VALUES ($productID, $accountNum, $rating)");
		}
		else
		{
			$query = $this->db->query("UPDATE rating SET rating=$rating WHERE product_id=$productID AND account_id=$accountNum");
		}
	}
}
?>