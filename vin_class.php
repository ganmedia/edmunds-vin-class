
<?php

//include 'functions.php';

class Edmunds_vin_decorer {

	public function __construct($vin, $api_key = 'dc9a9ffxmhbdbcqhv2h5d6ez') {
		$this->urlcardata = 'http://api.edmunds.com/v1/api/toolsrepository/vindecoder?vin=' . $vin . '&fmt=json&api_key=' . $api_key;
		$this->json = file_get_contents($this->urlcardata);
		$this->data = json_decode($this->json, true);
		$this->base_json_path = $this->data['styleHolder'][0];
	}

	public function Make() { #Toyota
		return $this->base_json_path['makeName'];
	}
	public function Model() { #Corolla
		return $this->base_json_path['modelName'];
	}
	public function Year() { #2013
		return $this->base_json_path['year'];
	}
	public function TransmissionType() { #Automatic
		return $this->base_json_path['transmissionType'];
	}
	public function EngineType() { #Gas
		return $this->base_json_path['engineType'];
	}
	public function EngineFuelType() { #premium unleaded (required)
		return $this->base_json_path['engineFuelType'];
	}
	public function EngineCylinder() { #6
		return $this->base_json_path['engineCylinder'];
	}
	public function EngineSize() { #3.7
		return $this->base_json_path['engineSize'];
	}
	public function VehicleType() { #Car
		return $this->base_json_path['categories']['PRIMARY_BODY_TYPE'][0];
	}
	public function VehicleStyle() { #Sedan
		return $this->base_json_path['categories']['Vehicle Style'][0];
	}
	public function VehicleSize() { #Midsize
		return $this->base_json_path['categories']['Vehicle Size'][0];
	}
	public function Market() { #Simple Array(Luxury, Performance) 
		return $this->base_json_path['categories']['Market'];
	}
	public function AirConditioning() { #Multiple Array(Climate Control Memory, Front Air Conditioning) 
		return $this->base_json_path['attributeGroups']['AIR_CONDITIONING']['attributes'];
	}
	public function MobileConnectivity() { #Multiple Array(Phone, Bluetooth) 
		return $this->base_json_path['attributeGroups']['MOBILE_CONNECTIVITY']['attributes'];
	}
	public function NumberOfDoors() { #A number, for example: 4
		return $this->base_json_path['attributeGroups']['DOORS']['attributes']['NUMBER_OF_DOORS']['value'];
	}
	public function Airbags() { #Head Airbag, Passenger Airbag
		return $this->base_json_path['attributeGroups']['AIRBAGS']['attributes'];
	}
	public function ExteriorLights() { #Front Fog Lights, Xenon Headlights
		return $this->base_json_path['attributeGroups']['EXTERIOR_LIGHTS']['attributes'];
	}
	public function ExteriorDimensions() { #WHEELBASE, OVERALL LENGTH
		return $this->base_json_path['attributeGroups']['EXTERIOR_DIMENSIONS']['attributes'];
	}


} # CLASS END

$my_car = new Edmunds_vin_decorer('19UUA96249A800952');

print_r($my_car->ExteriorDimensions());

########### DATA - VARIABLES IMPORTANTES ############


// $car_id = $base_json_path['id'];
// $make = $base_json_path['makeName'];
// $model = $base_json_path['modelName'];
// $year = $base_json_path['year'];
// $transmission_type = $base_json_path['transmissionType'];
// $engine_type = $base_json_path['engineType']; # GAS
// $engine_fuel_type = $base_json_path['engineFuelType'];
// $engine_cylinder = $base_json_path['engineCylinder'];
// $engine_size = $base_json_path['engineSize'];
// $vehicle_type = $base_json_path['categories']['PRIMARY_BODY_TYPE'][0]; # CAR, TRUCK, ETC
// $vehicle_style = $base_json_path['categories']['Vehicle Style'][0]; # SEDAN, SUV, ETC
// $vehicle_size = $base_json_path['categories']['Vehicle Size'][0]; # MIDSIZE
// $market = multiples_values($base_json_path['categories']['Market']); # PERFORMACE, LUXURY, ETC
// $air_conditioning = multiples_values_array($base_json_path['attributeGroups']['AIR_CONDITIONING']['attributes']);
// $mobile_connectivity = multiples_values_array($base_json_path['attributeGroups']['MOBILE_CONNECTIVITY']['attributes']);
// $number_of_doors = $base_json_path['attributeGroups']['DOORS']['attributes']['NUMBER_OF_DOORS']['value'];
// $airbags = multiples_values_array($base_json_path['attributeGroups']['AIRBAGS']['attributes']);
// $exterior_lights = multiples_values_array($base_json_path['attributeGroups']['EXTERIOR_LIGHTS']['attributes']);
// $exterior_dimensions = multiples_values_asociative_array($base_json_path['attributeGroups']['EXTERIOR_DIMENSIONS']['attributes']);
// $consumption_specification = multiples_values_asociative_array($base_json_path['attributeGroups']['SPECIFICATIONS']['attributes']);
// $exterior_lights = multiples_values_array($base_json_path['attributeGroups']['EXTERIOR_LIGHTS']['attributes']);

################### END ######################

############ MEDIA ###############
// $base_media_path = 'http://media.ed.edmunds-media.com';
// $urlmedia = 'http://api.edmunds.com/v1/api/vehiclephoto/service/findphotosbystyleid?styleId=' . $car_id . '&api_key=' . $api_key . '&fmt=json';
// $json_media = file_get_contents($urlmedia);
// $media = json_decode($json_media, true);

//echo $urlcardata;

// $find_me = '500.jpg';

// for ($i=0; $i < count($media); $i++) {
// 	foreach ($media[$i]['photoSrcs'] as $key => $value) {
// 	 	$pos = strpos($value, $find_me);
// 		if ($pos === false) {
// 			continue;
// 		}
// 		else {
// 			$car_photos[$media[$i]['vdpOrder']] = $base_media_path.$value;
// 		}
// 		 }
// }

// ksort($car_photos);



?>