
<?php

class Edmunds_vin_decorer {

	public function __construct($vin, $api_key = 'dc9a9ffxmhbdbcqhv2h5d6ez') {
		$this->urlcardata = 'http://api.edmunds.com/v1/api/toolsrepository/vindecoder?vin=' . $vin . '&fmt=json&api_key=' . $api_key;
		$this->json = file_get_contents($this->urlcardata);
		$this->data = json_decode($this->json, true);
		$this->base_json_path = $this->data['styleHolder'][0];
	}

	public function Make() { # OUTPUT EXAMPLE: Toyota
		return $this->base_json_path['makeName'];
	}
	public function Model() { # OUTPUT EXAMPLE: Corolla
		return $this->base_json_path['modelName'];
	}
	public function Year() { # OUTPUT EXAMPLE: 2013
		return $this->base_json_path['year'];
	}
	public function TransmissionType() { # OUTPUT EXAMPLE: Automatic
		return $this->base_json_path['transmissionType'];
	}
	public function EngineType() { # OUTPUT EXAMPLE: Gas
		return $this->base_json_path['engineType'];
	}
	public function EngineFuelType() { # OUTPUT EXAMPLE: premium unleaded (required)
		return $this->base_json_path['engineFuelType'];
	}
	public function EngineCylinder() { # OUTPUT EXAMPLE: 6
		return $this->base_json_path['engineCylinder'];
	}
	public function EngineSize() { # OUTPUT EXAMPLE: 3.7
		return $this->base_json_path['engineSize'];
	}
	public function VehicleType() { # OUTPUT EXAMPLE: Car
		return $this->base_json_path['categories']['PRIMARY_BODY_TYPE'][0];
	}
	public function VehicleStyle() { # OUTPUT EXAMPLE: Sedan
		return $this->base_json_path['categories']['Vehicle Style'][0];
	}
	public function VehicleSize() { # OUTPUT EXAMPLE: Midsize
		return $this->base_json_path['categories']['Vehicle Size'][0];
	}
	public function Market() { # OUTPUT EXAMPLE: Simple Array(Luxury, Performance) 
		return $this->base_json_path['categories']['Market'];
	}
	public function AirConditioning() { # OUTPUT EXAMPLE: Array(REAR_HEAT=>rear ventilation ducts, AIR_FILTRATION=>interior air filtration) 
		$air = array();
		$air_array = $this->base_json_path['attributeGroups']['AIR_CONDITIONING']['attributes'];
		foreach ($air_array as $key=>$value) {
			$air[$value['name']] = $value['value'];
		}
		return $air;
	}
	public function MobileConnectivity() { # OUTPUT EXAMPLE: Array(PHONE=>pre-wired for phone, BLUETOOTH=>Bluetooth) 
		$mobile = array();
		$mobile_array = $this->base_json_path['attributeGroups']['MOBILE_CONNECTIVITY']['attributes'];
		foreach ($mobile_array as $key=>$value) {
			$mobile[$value['name']] = $value['value'];
		}
		return $mobile;
	}
	public function NumberOfDoors() { # OUTPUT EXAMPLE: A number, for example: 4
		return $this->base_json_path['attributeGroups']['DOORS']['attributes']['NUMBER_OF_DOORS']['value'];
	}
	public function Airbags() { # OUTPUT EXAMPLE: Array(HEAD_AIRBAGS=>front and rear, SIDE_AIRBAGS=>dual front)
		$airbags = array();
		$airbags_array = $this->base_json_path['attributeGroups']['AIRBAGS']['attributes'];
		foreach ($airbags_array as $key=>$value) {
			$airbags[$value['name']] = $value['value'];
		}
		return $airbags;
	}
	public function ExteriorLights() { # OUTPUT EXAMPLE: Front Fog Lights, Xenon Headlights
		$lights_array = $this->base_json_path['attributeGroups']['EXTERIOR_LIGHTS']['attributes'];
		$lights = array();
		foreach ($lights_array as $key => $value) {
			$lights[] = $key;
		}
		return $lights;
	}
	public function ExteriorDimensions() { # OUTPUT EXAMPLE: Array(WHEELBASE=>109.3, OVERALL_LENGTH=>193.4)
		$dimensions = array();
		$dimensions_array = $this->base_json_path['attributeGroups']['EXTERIOR_DIMENSIONS']['attributes'];
		foreach ($dimensions_array as $key=>$value) {
			$dimensions[$value['name']] = $value['value'];
		}
		return $dimensions;
	}
	public function ConsumptionSpecification() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		$consumption = array();
		$consumption_array = $this->base_json_path['attributeGroups']['SPECIFICATIONS']['attributes'];
		foreach ($consumption_array as $key=>$value) {
			$consumption[$value['name']] = $value['value'];
		}
		return $consumption;
	}
} # CLASS END

$my_car = new Edmunds_vin_decorer('1FAFP52U9XA140531');

print_r($my_car->ConsumptionSpecification());
echo '<br>';
// foreach ($my_car->ExteriorLights() as $item) {
// 	echo $item.'<br>';
// }
foreach ($my_car->ConsumptionSpecification() as $key=>$value) {
	echo $key . ': ' . $value . '<br>';
}

?>