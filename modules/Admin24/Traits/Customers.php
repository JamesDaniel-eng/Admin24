<?php

namespace Modules\Admin24\Traits;

use Modules\Admin24\Models\Business;
use Modules\Admin24\Models\Customer;
use Modules\Admin24\Models\TaxStatus as Status;
use Modules\Admin24\Models\BusinessBookKeepingMethod as BKMethod;
use Modules\Admin24\Models\BusinessType as Type;
use Modules\Admin24\Models\BusinessIndustry as Industry;

trait Customers
{
	public function getBusiness(){
		$business = Business::where('email', user()->email)->first();
		if ($business) {
			return $business;
		}
    }

    public function getCustomer($id){
		$customer = Customer::where('id', $id)->first();
		if ($customer) {
			return $customer;
		} else {
			return "No customer exists at the moment.";
		}
    }

	public function getCustomers(){
		$customers = Customer::all();
		if ($customers) {
			return $customers;
		} else {
			return "No customer exists at the moment.";
		}
    }

    public function getStatuses(){
    	$statuses = Status::all();
		if ($statuses) {
			return $statuses;
		}
    }

    public function getBKMethods(){
    	$bk_methods = BKMethod::all();
		if ($bk_methods) {
			return $bk_methods;
		}
    }
}