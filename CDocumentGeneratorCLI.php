<?php

/* 
CDocumentGeneratorCLI - Class what is used when we want to create a
  command-line tool which generates HTML documents from source codes.
Copyright (C) 2011 Aleksi Räsänen <aleksi.rasanen@runosydan.net>

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

	require 'CHTMLDocumentGenerator/CHTMLDocumentGenerator.php';

	// ***********************************************
	//	CDocumentGeneratorCLI
	/*!
		@brief Command line tool for document generator
		@author Aleksi Räsänen
		@copyright Aleksi Räsänen, 2011
		@email aleksi.rasanen@runosydan.net
		@license GNU AGPL
	*/
	// ***********************************************
	class CDocumentGeneratorCLI
	{
		private $argc;
		private $argv;
		private $input_file;
		private $output_file;
		private $CSS_file;

		// ***********************************************
		//	__construct
		/*!
			@brief Set argc and argv to class variable and
			  then checks parameters.
			@param $argc Number of arguments
			@param $argv Array of arguments
		*/
		// ***********************************************
		public function __construct( $argc, $argv )
		{
			$this->argc = $argc;
			$this->argv = $argv;
			$this->CSS_file = '';

			$this->checkParameters();
		}

		// ***********************************************
		//	checkParameters
		/*!
			@brief Check command line parameters and call
			  required methods
		*/
		// ***********************************************
		private function checkParameters()
		{
			if( $this->argc != 3 )
				$this->showHelp();

			if(! file_exists( $this->argv[1] ) )
			{
				echo 'File ' . $this->argv[1] . ' not found!' . "\n";
				die();
			}

			$this->input_file = $this->argv[1];
			$this->output_file = $this->argv[2];
		}

		// ***********************************************
		//	showHelp
		/*!
			@brief Show help to user how to use this app
			  and quit application
		*/
		// ***********************************************
		private function showHelp()
		{
			echo 'Usage: ' . $this->argv[0] . 
				' INPUT_FILE OUTPUT_FILE' . "\n";
			die();
		}

		// ***********************************************
		//	generateDocument
		/*!
			@brief Generates document and saves it to the file
		*/
		// ***********************************************
		public function generateDocument()
		{
			$cHTMLDocGen = new CHTMLDocumentGenerator( $this->argv[1] );

			if( $this->CSS_file != '' )
				$cHTMLDocGen->setCSSFile( $this->CSS_file );

			$html_document = $cHTMLDocGen->createHTMLDocument();

			$fh = fopen( $this->output_file . '.html', 'w' );
			fwrite( $fh, $html_document );
			fclose( $fh );
		}

		// ***********************************************
		//	setCSSFile
		/*!
			@brief Sets a CSS file to use
			@param $filename CSS filename
		*/
		// ***********************************************
		public function setCSSFile( $filename )
		{
			$this->CSS_file = $filename;
		}
	}
?>
