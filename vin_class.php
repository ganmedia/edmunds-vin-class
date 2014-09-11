
<?php

class Edmunds_vin_decorer {

	public function __construct($vin, $api_key = 'YOUR_API_KEY_HERE') { # The Edmunds API Key should be something like: dc8a9ffxmhcdbcdhv4h7d6fz
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
	public function FirstRowSeats() { # OUTPUT EXAMPLE: Array(EGE_HIGHWAY_MPG=>25, EPA_CITY_MPG=>17)
		return $this->characteristics_list('1ST_ROW_SEATS');
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
	public function Pricing() { # OUTPUT EXAMPLE: Multiple Array(POWER_OUTLET(S): 12V)
		return $this->characteristics_list('PRICING');
	}
	public function CargoDimensions() { # OUTPUT EXAMPLE: Multiple Array(POWER_OUTLET(S): 12V)
		return $this->characteristics_list('CARGO_DIMENSIONS');
	}
	public function StyleInfo() { # OUTPUT EXAMPLE: Multiple Array(EPA_CLASS=>Midsize Cars, WHERE_BUILT: United States)
		return $this->characteristics_list('STYLE_INFO');
	}
	public function Steering() { # OUTPUT EXAMPLE: Multiple Array(POWER_STEERING=>electric speed-proportional power steering)
		return $this->characteristics_list('STEERING');
	}
	public function DriveType() { # OUTPUT EXAMPLE: Multiple Array(DRIVEN_WHEELS=>all wheel drive)
		return $this->characteristics_list('DRIVE_TYPE');
	}
	public function Storage() { # OUTPUT EXAMPLE: Multiple Array(CUPHOLDERS_LOCATION=>front and rear, SEATBACK_STORAGE: front seatback storage)
		return $this->characteristics_list('STORAGE');
	}
	public function FrontPassengerSeat() { # OUTPUT EXAMPLE: Multiple Array(HEATED_PASSENGER_SEAT=>multi-level heating)
		return $this->characteristics_list('FRONT_PASSENGER_SEAT');
	}
	public function SeatingConfiguration() { # OUTPUT EXAMPLE: Multiple Array(1ST_ROW_SEATING_CAPACITY=>2)
		return $this->characteristics_list('SEATING_CONFIGURATION');
	}
	public function DriverSeat() { # OUTPUT EXAMPLE: Multiple Array(1ST_ROW_SEATING_CAPACITY=>2)
		return $this->characteristics_list('DRIVER_SEAT');
	}
	public function Windows() { # OUTPUT EXAMPLE: Multiple Array(1ST_ROW_SEATING_CAPACITY=>2)
		return $this->characteristics_list('WINDOWS');
	}
	public function Trunk() { # OUTPUT EXAMPLE: Multiple Array(1ST_ROW_SEATING_CAPACITY=>2)
		return $this->characteristics_list('TRUNK');
	}
	public function Sunroof() { # OUTPUT EXAMPLE: Multiple Array(1ST_ROW_SEATING_CAPACITY=>2)
		return $this->characteristics_list('SUNROOF');
	}
	public function InteriorDimensions() { # OUTPUT EXAMPLE: Multiple Array(1ST_ROW_SEATING_CAPACITY=>2)
		return $this->characteristics_list('INTERIOR_DIMENSIONS');
	}
	public function Security() { # OUTPUT EXAMPLE: Multiple Array(2ND_ROW_LEG_ROOM=>36.2, 1ST_ROW_HIP_ROOM=>55.7)
		return $this->characteristics_list('SECURITY');
	}
	public function InteriorFeatures() { # OUTPUT EXAMPLE: Multiple Array(FLOOR_MAT_MATERIAL=>carpet, CARGO_AREA_LIGHT=>trunk light)
		return $this->characteristics_list('MISC._INTERIOR_FEATURES');
	}

	# -------------
	public function ChildSafety() { # OUTPUT EXAMPLE: Simple Array(CHILD_SAFETY_LOCKS, CHILD_SEAT_ANCHORS)
		return $this->characteristics('CHILD_SAFETY');
	}
	public function Instrumentation() { # OUTPUT EXAMPLE: Simple Array(COMPASS, TACHOMETER)
		return $this->characteristics('INSTRUMENTATION');
	}
	public function TractionStabilityControl() { # OUTPUT EXAMPLE: Simple Array(COMPASS, TACHOMETER)
		return $this->characteristics('TRACTION/STABILITY_CONTROL');
	}
	public function NciStandardFacet() { # OUTPUT EXAMPLE: Simple Array(AUTOMATIC_CLIMATE_CONTROL, CD_MP3_PLAYBACK)
		return $this->characteristics('NCI_STANDARD_FACET');
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

# Simple Array
// foreach ($my_car->NciStandardFacet() as $item) {
// 	echo $item.'<br>';
// }

# Multiple Array
foreach ($my_car->pricing() as $key=>$value) {
	echo $key . ': ' . $value . '<br>';
}

?>