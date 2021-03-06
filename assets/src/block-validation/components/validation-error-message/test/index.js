/**
 * External dependencies
 */
import { render } from 'enzyme';

/**
 * Internal dependencies
 */
import ValidationErrorMessage from '../';

describe( 'ValidationErrorMessage', () => {
	it( 'renders an error with a custom message', () => {
		const errorMessage = render( <ValidationErrorMessage message="Hello World" /> );
		expect( errorMessage ).toMatchSnapshot();
	} );

	it( 'renders an error with a title', () => {
		const errorMessage = render( <ValidationErrorMessage title="Invalid attribute <code>onclick</code>" /> );
		expect( errorMessage ).toMatchSnapshot();
	} );

	it( 'renders an error for a custom error code', () => {
		const errorMessage = render( <ValidationErrorMessage code="some_other_error" /> );
		expect( errorMessage ).toMatchSnapshot();
	} );

	it( 'renders an error for an unknown error code', () => {
		const errorMessage = render( <ValidationErrorMessage /> );
		expect( errorMessage ).toMatchSnapshot();
	} );
} );
