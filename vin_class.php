
<?php

class Edmunds_vin_decorer {

	public function __construct($vin, $api_key = 'dc9a9ffxmhbdbcqhv2h5d6ez') {
		$this->urlcardata = 'http://api.edmunds.com/v1/api/toolsrepository/vindecoder?vin=' . $vin . '&fmt=json&api_key=' . $api_key;
		$this->json = file_get_contents($this->urlcardata);
		$this->data = json_decode($this->json, true);
		$this->base_json_path = $this->data['styleHolder'][0];
	}

	public function OfficialName() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		$name = array();
		$name_array = $this->base_json_path['attributeGroups']['MAIN']['attributes'];
		foreach ($name_array as $key=>$value) {
			if ($value['name'] == 'NAME') {
				$name[$value['name']] = $value['value'];
			}
		}
		return $name;
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
	public function NumberOfDoors() { # OUTPUT EXAMPLE: A number, for example: 4
		return $this->base_json_path['attributeGroups']['DOORS']['attributes']['NUMBER_OF_DOORS']['value'];
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
		return $this->characteristics_list('AIR_CONDITIONING');
	}
	public function MobileConnectivity() { # OUTPUT EXAMPLE: Array(PHONE=>pre-wired for phone, BLUETOOTH=>Bluetooth) 
		return $this->characteristics_list('MOBILE_CONNECTIVITY');
	}
	public function Airbags() { # OUTPUT EXAMPLE: Array(HEAD_AIRBAGS=>front and rear, SIDE_AIRBAGS=>dual front)
		return $this->characteristics_list('AIRBAGS');
	}
	public function ExteriorLights() { # OUTPUT EXAMPLE: Front Fog Lights, Xenon Headlights
		return $this->characteristics_list('EXTERIOR_LIGHTS');
	}
	public function ExteriorDimensions() { # OUTPUT EXAMPLE: Array(WHEELBASE=>109.3, OVERALL_LENGTH=>193.4)
		return $this->characteristics_list('EXTERIOR_DIMENSIONS');
	}
	public function ConsumptionSpecification() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		return $this->characteristics_list('SPECIFICATIONS');
	}
	public function BrakeSystem() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		return $this->characteristics_list('BRAKE_SYSTEM');
	}
	public function CrashTestRatings() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		return $this->characteristics_list('CRASH_TEST_RATINGS');
	}
	public function Mirrors() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		return $this->characteristics_list('MIRRORS');
	}
	public function InteriorTrim() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		return $this->characteristics_list('INTERIOR_TRIM');
	}
	public function SteeringWheel() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		return $this->characteristics_list('STEERING_WHEEL');
	}
	public function SecondRowSeats() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		return $this->characteristics_list('2ND_ROW_SEATS');
	}
	public function PowerOutlets() { # OUTPUT EXAMPLE: Multiple Array(POWER_OUTLET(S): 12V)
		return $this->characteristics_list('POWER_OUTLETS');
	}
	public function SeatBelts() { # OUTPUT EXAMPLE: Multiple Array(POWER_OUTLET(S): 12V)
		return $this->characteristics_list('SEATBELTS');
	}
	public function Suspension() { # OUTPUT EXAMPLE: Multiple Array(POWER_OUTLET(S): 12V)
		return $this->characteristics_list('SUSPENSION');
	}

	# -------------
	public function ChildSafety() { # OUTPUT EXAMPLE: Simple Array(CHILD_SAFETY_LOCKS, CHILD_SEAT_ANCHORS)
		return $this->characteristics('CHILD_SAFETY');
	}
	public function Instrumentation() { # OUTPUT EXAMPLE: Simple Array(COMPASS, TACHOMETER)
		return $this->characteristics('INSTRUMENTATION');
	}

	public function characteristics($attribute) {
		$characteristics = array();
		$characteristics_array = $this->base_json_path['attributeGroups'][$attribute]['attributes'];
		foreach ($characteristics_array as $key=>$value) {
			$characteristics[] = $key;
		}
		return $characteristics;
	}
	public function characteristics_list($attribute) {
		$characteristics = array();
		$characteristics_array = $this->base_json_path['attributeGroups'][$attribute]['attributes'];
		foreach ($characteristics_array as $key=>$value) {
			$characteristics[$value['name']] = $value['value'];
		}
		return $characteristics;
	}

} # CLASS END

$my_car = new Edmunds_vin_decorer('19UUA96249A800952');

// print_r($my_car->SecondRowSeats());
// echo '<br>';
// foreach ($my_car->2ndRowSeats() as $item) {
// 	echo $item.'<br>';
// }
foreach ($my_car->Suspension() as $key=>$value) {
	echo $key . ': ' . $value . '<br>';
}

?>