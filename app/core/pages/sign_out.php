<?php
if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
	unset($_SESSION['user']);

	redirect('home');
	die;
	}
