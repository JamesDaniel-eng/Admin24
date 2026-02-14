<?php

namespace Modules\Admin24\Traits;

use Modules\Admin24\Models\Business;
use Modules\Admin24\Models\TaxStatus as Status;
use Modules\Admin24\Models\BusinessBookKeepingMethod as BKMethod;
use Modules\Admin24\Models\BusinessType as Type;
use Modules\Admin24\Models\BusinessIndustry as Industry;

trait Businesses
{
	public function getBusinesses(){
		$businesses = Business::all();
		if ($businesses) {
			return $businesses;
		} else {
			return "No customer business exists at the moment.";
		}
    }

	public function getBusiness(){
		$business = Business::where('email', user()->email)->first();
		if ($business) {
			return $business;
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

    public function getTypes(){
    	$types = Type::all();
		if ($types) {
			return $types;
		}
    }

    public function getIndustries(){
    	$industries = Industry::all();
		if ($industries) {
			return $industries;
		}
    }
}