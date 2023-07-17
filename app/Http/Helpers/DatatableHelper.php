<?php

/**
 * Get array keys, where values are equal/like a string
 *
 * @param array $array
 * @param string $string
 * @param string $operator
 * @param string $case
 * @return void
 */
function getKeysWhereValues($array, $string, $operator = 'like', $case = 'insensitive'): array
{
	$collection = collect($array);
	return $collection->filter(function ($value) use ($string, $operator, $case) {
		if ($case == 'insensitive') {
			$value = strtolower($value);
			$string = strtolower($string);
		}

		if ($operator == 'like') {
			return str_contains(strtolower($value), $string);
		} else if ($operator == '=') {
			return $value == $string;
		}

		return false;
	})->keys()->toArray();
}
