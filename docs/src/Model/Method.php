<?php
/**
 * Class Method.
 *
 * @package AmpProject\AmpWP
 */

namespace AmpProject\AmpWP\Documentation\Model;

/**
 * Documentation reference object representing a method.
 *
 * @property string     $name
 * @property string     $namespace
 * @property string[]   $aliases
 * @property int        $line
 * @property int        $end_line
 * @property bool       $final
 * @property bool       $abstract
 * @property bool       $static
 * @property string     $visibility
 * @property Argument[] $arguments
 * @property DocBlock   $doc
 * @property Usage[]    $uses
 * @property Hook[]     $hooks
 */
final class Method implements Leaf {

	use LeafConstruction;
	use HasDocBlock;

	/**
	 * Get an associative array of known keys.
	 *
	 * @return string[]
	 */
	protected function get_known_keys() {
		return [
			'name',
			'namespace',
			'aliases',
			'line',
			'end_line',
			'final',
			'abstract',
			'static',
			'visibility',
			'arguments',
			'doc',
			'uses',
			'hooks',
		];
	}

	/**
	 * Process the arguments entry.
	 *
	 * @param array $value Array of argument entries.
	 */
	private function process_arguments( $value ) {
		$this->arguments = [];

		foreach ( $value as $argument ) {
			$this->arguments[ $argument[ 'name' ] ] = new Argument( $argument, $this );
		}
	}

	/**
	 * Process the uses entry.
	 *
	 * @param array $value Array of usage entries.
	 */
	private function process_uses( $value ) {
		$this->uses = [];

		foreach ( $value as $use ) {
			$this->uses[ $use[ 'name' ] ] = new Usage( $use, $this );
		}
	}

	/**
	 * Process the hooks entry.
	 *
	 * @param array $value Array of hook entries.
	 */
	private function process_hooks( $value ) {
		$this->hooks = [];

		foreach ( $value as $hook ) {
			$this->hooks[ $hook[ 'name' ] ] = new Hook( $hook, $this );
		}
	}

	/**
	 * Get the signature of the method.
	 *
	 * @return string Method signature.
	 */
	public function get_signature() {
		return sprintf(
			'%s%s%s%s %s(%s)',
			$this->final ? 'final ' : '',
			$this->abstract ? 'abstract ' : '',
			$this->static ? 'static ' : '',
			$this->visibility ?: 'public',
			$this->name,
			count( $this->arguments ) > 0
				? ' ' . implode( ', ', $this->get_arguments() ) . ' '
				: ''
		);
	}

	/**
	 * Get the argument signatures.
	 *
	 * @return string[] Array of argument signatures.
	 */
	private function get_arguments(  ) {
		$arguments = [];

		foreach ( $this->arguments as $argument ) {
			$arguments[] = sprintf(
				'%s%s%s',
				$argument->type ? "{$this->map_alias( $argument->type )} " : '',
				$argument->name,
				$argument->default ? " = {$argument->default}" : ''
			);
		}

		return $arguments;
	}

	/**
	 * Get the alias for a fully qualified element.
	 *
	 * @param string $fully_qualified_element Fully qualified element to map an
	 *                                        alias to.
	 * @return string Alias, or fully qualified element if none found.
	 */
	private function map_alias( $fully_qualified_element ) {
		if ( empty( $fully_qualified_element ) ) {
			return '';
		}

		$key = array_search( $fully_qualified_element, $this->aliases, true );

		if ( false === $key ) {
			return $fully_qualified_element;
		}

		return $key;
	}
}
