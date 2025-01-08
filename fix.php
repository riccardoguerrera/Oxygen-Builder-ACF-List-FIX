<?php

  function rgwebdev_oxy_acf_fix($dynamic_data) {
		foreach ($dynamic_data as $index1 => $ddata) {
			if (isset($ddata) && !empty($ddata) && substr($ddata['data'], 0, 4) === 'acf_') {
				if (is_object($ddata)) continue;
				foreach ($ddata['properties'] as $index2 => $dd) {
					if (is_object($dd)) continue;
					foreach ($dd as $property => $value) {
						if (isset($property) && !empty($value) && $property === 'data') {
							$field_group_name = rgwebdev_oxy_acf_fix_get_field_group_by_field_slug($dd['data']);
							$dynamic_data[$index1]['properties'][$index2]['name'] = $field_group_name . ' - ' . $dd['name'] . ' ( ' . $dd['data'] . ' ) '; 
						}
					}
				}
			}
		}
		return($dynamic_data);
	}

	add_filter('oxygen_custom_dynamic_data', 'rgwebdev_oxy_acf_fix', 999, 1);


	function rgwebdev_oxy_acf_fix_get_field_group_by_field_slug($field_slug) {
		$field_groups = acf_get_field_groups();
		foreach ($field_groups as $group) {
			$fields = acf_get_fields($group['key']);
			if ($fields) {
				foreach ($fields as $field) {
					if ($field['name'] === $field_slug) {
						return $group['title']; 
					}
				}
			}
		}
		return null;
	}
