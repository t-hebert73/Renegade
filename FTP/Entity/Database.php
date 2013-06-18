<?php
	/**
	* Author : Miguel Mawyin
	* Last Modified : June 11, 2013
	* Description : Database class, used to handle all database queries.
	*/
	namespace Renegade\FTP\Entity;
	
	class Database
	{	
		// Members
		private $con;
		private $res;
		public $rows;
		
		// Constructor
		function __construct(){
			// Connect to the database
			// Add the database information down below
			$this->con = mysqli_connect( 'localhost', 'root', 'root', 'renegade' );
			if( mysqli_connect_errno() == true ){
				// Could not establish a connection with the database
				$this->con = false;
				die( 'Could not establish a connection with the database. Error : '.mysqli_connect_errno());
			}
			
			// Initialize the other members
			$this->res = null;
			$this->rows = 0;
		}
		
		// Destructor
		function __destruct(){
			// Check if a connection has been made
			if( $this->con ){
				// Close the connection
				mysqli_close($this->con);
			}
		}
		
		// Query the database
		// This function will also set the rows variable to see how many rows returned
		// $q - the query to be executed.
		function query( $q ){
			// Query the database
			$this->res = mysqli_query($this->con, $q);
			
			// Set the rows
			$this->rows = 0;
			
			// Check if its a select statement
			if( strtolower($q[0]) == 's' ){
				// Set the rows
				$this->rows = mysqli_num_rows($this->res);
			}
		}
		
		// Fetch function the next available row of the query
		// Returns nothing is there's no query available
		function fetch(){
			// Check that a query has been made
			if( $this->res == null ){
				// Do nothing
				return null;
			}
			
			// Return the next array in the query
			return mysqli_fetch_array($this->res);
		}
	}