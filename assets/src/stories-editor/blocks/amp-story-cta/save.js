/**
 * External dependencies
 */
import PropTypes from 'prop-types';

/**
 * WordPress dependencies
 */
import { RichText } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import { getClassNameFromBlockAttributes, getStylesFromBlockAttributes, getUniqueId } from '../../helpers';

const CallToActionSave = ( { attributes } ) => {
	const {
		anchor,
		btnPositionLeft,
		btnPositionTop,
		btnWidth,
		btnHeight,
		text,
		url,
	} = attributes;

	const className = getClassNameFromBlockAttributes( { ...attributes, className: 'amp-block-story-cta__link' } );
	const styles = getStylesFromBlockAttributes( attributes );

	styles.top = btnPositionTop ? `${ btnPositionTop }%` : undefined;
	styles.left = btnPositionLeft ? `${ btnPositionLeft }%` : undefined;
	styles.width = btnWidth ? `${ btnWidth }%` : undefined;
	styles.height = btnHeight ? `${ btnHeight }%` : undefined;

	return (
		<amp-story-cta-layer id={ anchor ? anchor : getUniqueId() }>
			<div className="amp-cta-button-wrapper">
				<RichText.Content
					tagName="a"
					className={ className }
					href={ url }
					style={ styles }
					value={ text }
				/>
			</div>
		</amp-story-cta-layer>
	);
};

CallToActionSave.propTypes = {
	attributes: PropTypes.shape( {
		anchor: PropTypes.string,
		url: PropTypes.string,
		text: PropTypes.string,
		btnPositionLeft: PropTypes.number,
		btnPositionTop: PropTypes.number,
		btnWidth: PropTypes.number,
		btnHeight: PropTypes.number,
		backgroundColor: PropTypes.shape( {
			color: PropTypes.string,
			name: PropTypes.string,
			slug: PropTypes.string,
			class: PropTypes.string,
		} ).isRequired,
		customBackgroundColor: PropTypes.string,
		textColor: PropTypes.shape( {
			color: PropTypes.string,
			name: PropTypes.string,
			slug: PropTypes.string,
			class: PropTypes.string,
		} ).isRequired,
		customTextColor: PropTypes.string,
		fontSize: PropTypes.shape( {
			name: PropTypes.string,
			shortName: PropTypes.string,
			size: PropTypes.number,
			slug: PropTypes.string,
		} ).isRequired,
		customFontSize: PropTypes.number,
	} ).isRequired,
};

export default CallToActionSave;
