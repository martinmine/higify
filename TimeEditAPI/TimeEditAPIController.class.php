<?php
require_once('TimeEditAPIModel.class.php');
require_once('TimeEditAPIView.class.php');

class TimeEditAPIController
{
	protected $model;

	function __construct($queryString)
	{
		$this->model = new TimeEditAPIModel($queryString);
	}

	function getDOM()
	{
		$response = $this->model->pullResponse();
		return TimeEditApiView::parseToDOM($response);
	}



}
?>