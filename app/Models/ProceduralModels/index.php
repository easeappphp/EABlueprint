<?php
			
$data->name = "EaseApp";
$this->session->set('license', 'MIT');
$data->license = $this->container->get('\Odan\Session\PhpSession')->get('license');
$data->userSessionInfo = $this->container->get('\Odan\Session\PhpSession')->get('bar');

?>