<?php
  function rgwebdev_oxy_acf_fix($dynamic_data) {
  	foreach ($dynamic_data as $index1 => $ddata) {
  		if (isset($ddata) && !empty($ddata) && $ddata['data'] === 'acf_content') {
  			if (is_object($ddata)) continue;
  			foreach ($ddata['properties'] as $index2 => $dd) {
  				if (is_object($dd)) continue;
  				foreach ($dd as $property => $value) {
  					if (isset($property) && !empty($value) && $property === 'data') 
  						$dynamic_data[$index1]['properties'][$index2]['name'] = $dd['name'] . ' ( ' . $dd['data'] . ' ) '; 
  				}
  			}
  		}
  	}
  	return($dynamic_data);
  }
  
  add_filter('oxygen_custom_dynamic_data', 'rgwebdev_oxy_acf_fix', 999, 1);
?>