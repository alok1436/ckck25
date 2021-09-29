<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Customer;
use App\Models\Routeknown;
use App\Models\Stockbroker;
use App\Models\Customergroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            $city           = City::where('cityName', $row['city'])->first();
            $customergroup  = Customergroup::where('groupName', $row['group'])->first();
            $routeknown     = Routeknown::where('routeName', $row['routs_of_known'])->first();
            $stockBroker     = Stockbroker::where('brokerName', $row['stock_broker'])->first();
           

            if(!$city && $row['city'] !=''){
                $city               = new City;
                $city->cityName     = $row['city'];
                $city->createdBy    = 1;
                $city->save();
            }
            if(!$customergroup && $row['group'] !=''){
                $customergroup              = new Customergroup;
                $customergroup->groupName   = $row['group'];
                $customergroup->createdBy   = 1;
                $customergroup->isActive    = 'Y';
                $customergroup->save();
            }
            if(!$routeknown && $row['routs_of_known'] !=''){
                $routeknown              = new Routeknown;
                $routeknown->routeName   = $row['routs_of_known'];
                $routeknown->createdBy   = 1;
                $routeknown->save();
            }
            if(!$stockBroker && $row['stock_broker'] !=''){
                $stockBroker              = new Stockbroker;
                $stockBroker->brokerName  = $row['stock_broker'];
                $stockBroker->createdBy   = 1;
                $stockBroker->isDelete   = 'N';
                $stockBroker->save();
            }


            $alreadyData                = Customer::where('phonenumber1', $row['number'])->first();
            $customer                   = $alreadyData ? $alreadyData : new Customer;
            $customer->name             = $row['name'] ? $row['name'] : 'no name';
    		$customer->phonenumber1     = $row['number'];
            $customer->phonenumber2     = $row['2number2'];
            $customer->gender           = $row['gender']=='남' ? 'M' : ($row['gender']=='여' ? 'F' : 'O');
			$customer->date             = date('Y-m-d');
            $customer->age              = $row['age'];
			$customer->city_id          = $city ? $city->id : 0;
            $customer->customerGroupID  = $customergroup ? $customergroup->id : 0;
			$customer->email            = $row['email'];
			$customer->routesOfKnownID  = $routeknown ? $routeknown->id : 0;
			$customer->stockBroker      = $stockBroker ? $stockBroker->id : '';
            $customer->accountNumber    = $row['account_number'];
            $customer->address          = $row['address'];
            $customer->createdBy        = 1;
            $customer->updatedBy        = 1;
			$customer->save();
		}
	}
}
