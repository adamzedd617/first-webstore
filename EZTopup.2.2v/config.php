<?php

	function error(){
		global $link;
	 	if($link === false){
	    die("ERROR: Could not connect. " . mysqli_connect_error());
		}
	}
	
	function delete(){
		global $link;
		global $sql;
		unset($link);
		unset($sql);
	}

	//Create Database for eztopup
	$link = mysqli_connect("localhost","root","");

	error();

	$sql = "CREATE DATABASE Eztopup";
	mysqli_query($link,$sql);

	delete();

	//Create table for Eztopup database
	$link = mysqli_connect("localhost","root","","Eztopup");

	error();

	$sql = "CREATE TABLE users(
			id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
			name VARCHAR(255) NOT NULL,
			password VARCHAR(255) NOT NULL,
			email VARCHAR(255) NOT NULL,
			phonenum VARCHAR(100) NOT NULL,
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP
			)";
	mysqli_query($link,$sql);

	delete();

	//connecting to Eztopup database
	$link = mysqli_connect("localhost","root","","Eztopup");

	error();
?>