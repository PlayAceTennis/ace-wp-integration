( function ( blocks, element, blockEditor, components, i18n ) {
	var el = element.createElement;
	var __ = i18n.__;
	var InspectorControls = blockEditor.InspectorControls;
	var PanelBody = components.PanelBody;
	var SelectControl = components.SelectControl;

	var WIDGET_TYPES = [
		{ label: __( 'Booking', 'ace-wp-integration' ), value: 'booking' },
		{ label: __( 'News', 'ace-wp-integration' ), value: 'news' },
		{ label: __( 'Calendar', 'ace-wp-integration' ), value: 'calendar' },
	];

	blocks.registerBlockType( 'ace/widget', {
		edit: function ( props ) {
			var attributes = props.attributes;
			var setAttributes = props.setAttributes;

			return el(
				element.Fragment,
				{},
				el(
					InspectorControls,
					{},
					el(
						PanelBody,
						{ title: __( 'Ace Widget Settings', 'ace-wp-integration' ) },
						el( SelectControl, {
							label: __( 'Widget Type', 'ace-wp-integration' ),
							value: attributes.type,
							options: WIDGET_TYPES,
							onChange: function ( value ) {
								setAttributes( { type: value } );
							},
						} )
					)
				),
				el(
					'div',
					{ className: props.className + ' ace-widget-placeholder' },
					el( 'strong', {}, __( 'Ace Widget', 'ace-wp-integration' ) ),
					el( 'p', {}, __( 'Type: ', 'ace-wp-integration' ) + attributes.type )
				)
			);
		},

		save: function ( props ) {
			return el( 'ace-widget', { type: props.attributes.type } );
		},
	} );
} )(
	window.wp.blocks,
	window.wp.element,
	window.wp.blockEditor,
	window.wp.components,
	window.wp.i18n
);
