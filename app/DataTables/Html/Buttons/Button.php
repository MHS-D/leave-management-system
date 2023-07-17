<?php

namespace App\DataTables\Html\Buttons;

use Illuminate\Support\Arr;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Yajra\DataTables\Html\Options\Plugins\SearchPanes;

class Button
{
	protected $data = [];

	/**
	 * @param  array  $data
	 */
	public function __construct($data = [])
	{
		$this->data['text'] = $data['text'] ?? '';
		$this->data['type'] = $data['type'] ?? null;
		$this->data['status'] = $data['status'] ?? 'primary';
		$this->data['tag'] = $data['tag'] ?? 'button';
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
	 * Set button icon.
	 *
	 * @param  string $value
	 * 
	 * @return $this
	 */
	public function icon(string $value): static
	{
		$this->data['icon'] = $value;

		return $this;
	}

	/**
	 * Set button type.
	 *
	 * @param  string $value
	 * 
	 * @return $this
	 */
	public function type(string $value): static
	{
		$this->data['type'] = $value;

		return $this;
	}

	/**
	 * Set button status.
	 *
	 * @param  string $value
	 * 
	 * @return $this
	 */
	public function status(string $value): static
	{
		$this->data['status'] = $value;

		return $this;
	}

	/**
	 * Set button main class.
	 *
	 * @param  string $value
	 * 
	 * @return $this
	 */
	public function mainClass(string $value): static
	{
		$this->data['mainClass'] = $value;

		return $this;
	}

	/**
	 * Set button additional class.
	 *
	 * @param  string $value
	 * @param  bool $reset
	 * 
	 * @return $this
	 */
	public function additionalClass(string $value, bool $reset = false): static
	{
		$this->data['additionalClass'] = $reset ? $value : ($this->data['additionalClass'] ?? '') . ' ' . $value;

		return $this;
	}

	/**
	 * Set button attributes.
	 *
	 * @param  array $value
	 * 
	 * @return $this
	 */
	public function attributes(array $value): static
	{
		$this->data['attributes'] = $value;

		return $this;
	}

	/**
	 * Set button tag.
	 *
	 * @param  string $value
	 * 
	 * @return $this
	 */
	public function tag(string $value): static
	{
		$this->data['tag'] = $value;

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
		$class = $this->generateClassString();
		$attributesString = $this->generateAttributesString();
		$tag = $this->data['tag'];

		$html = '';

		$html .= '<' . $tag . ' class="' . $class . '" ' . $attributesString . '>';

		if (isset($this->data['icon'])) {
			$html .= '<i class="' . $this->data['icon'] . '"></i>';
		}

		if (isset($this->data['text'])) {
			if (isset($this->data['icon'])) {
				$html .= ' ';
			}

			$html .= $this->data['text'];
		}

		$html .= '</' . $tag . '>';

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
