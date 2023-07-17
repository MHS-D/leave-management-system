<?php

namespace App\DataTables\Html;

use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Options\Plugins\SearchPanes;

class Badge
{
	protected $data = [];

	/**
	 * @param  array  $data
	 */
	public function __construct($data = [])
	{
		$this->data['text'] = $data['text'] ?? '';
		$this->data['bootstrap_color'] = $data['bootstrap_color'] ?? null;
	}

	/**
	 * Set button text.
	 *
	 * @param  string $value
	 * 
	 * @return $this
	 */
	public function text(string $value): static
	{
		$this->data['text'] = $value;

		return $this;
	}

	/**
	 * Set button bootstrap color.
	 *
	 * @param  string $value
	 * 
	 * @return $this
	 */
	public function bootstrapColor(string $value): static
	{
		$this->data['bootstrap_color'] = $value;

		return $this;
	}

	/**
	 * Make a new button instance.
	 *
	 * @param  array $data
	 *
	 * @return static
	 */
	public static function make(array $data = []): static
	{
		return new static($data);
	}

	/**
	 * Render button HTML.
	 *
	 * @return string
	 */
	public function render(): string
	{
		$text = $this->data['text'] ?? '';
		$bootstrapColor = $this->data['bootstrap_color'] ?? 'secondary';

		$html = '<span class="badge badge-light-' . $bootstrapColor . '">' . $text . '</span>';

		return $html;
	}

	/**
	 * Generate button class string
	 *
	 * @return string
	 */
	private function generateClassString(): string
	{
		$mainClass = $this->data['mainClass'] ?? null;
		if ($mainClass === null) {
			$mainClass = 'btn ';

			if (isset($this->data['type'])) {
				$mainClass .= ' btn-' . $this->data['type'];
			}

			if (isset($this->data['status'])) {
				if (strpos($mainClass, 'btn-') === false) {
					$mainClass .= ' btn-';
				}

				$mainClass .= '-' . $this->data['status'];
			}
		}

		$class =  ($mainClass ?? '') . ' ' . ($this->data['additionalClass'] ?? '');

		if (isset($this->data['icon'])) {
			$class .= ' btn-icon';
		}

		return $class;
	}

	/**
	 * Generate button attributes string
	 *
	 * @return string
	 */
	private function generateAttributesString(): string
	{
		$attributesString = '';

		foreach ($this->data['attributes'] ?? [] as $key => $value) {
			$attributesString .= $key . '="' . $value . '" ';
		}

		return $attributesString;
	}
}
