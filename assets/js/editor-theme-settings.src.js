/**
 * Editor Theme Settings
 * 
 * @package GT Next
 */

/**
 * WordPress dependencies
 */
const { registerPlugin } = wp.plugins;
const { Component } = wp.element;
const { compose } = wp.compose;
const { withSelect } = wp.data;

/**
 * Theme Settings Editor Plugin
 */
class pageTemplateBodyClass extends Component {
	componentDidUpdate() {
		const {
			pageTemplate,
			postType,
		} = this.props;

		// Return early if post type is not a static page.
		if ( ! postType || 'page' !== postType.slug ) {
			return null;
		}

		if ( 'templates/template-fullwidth.php' === pageTemplate ) {
			document.body.classList.add( 'gt-fullwidth-page-layout' );
			document.body.classList.remove( 'gt-page-title-hidden' );
		} else if ( 'templates/template-no-title.php' === pageTemplate ) {
			document.body.classList.add( 'gt-page-title-hidden' );
			document.body.classList.remove( 'gt-fullwidth-page-layout' );
		} else if ( 'templates/template-fullwidth-no-title.php' === pageTemplate ) {
			document.body.classList.add( 'gt-fullwidth-page-layout' );
			document.body.classList.add( 'gt-page-title-hidden' );
		} else {
			document.body.classList.remove( 'gt-fullwidth-page-layout' );
			document.body.classList.remove( 'gt-page-title-hidden' );
		}
	}

	render() {
		return null;
	}
}

const plugin = compose(
	withSelect( ( select ) => {
		const { getEditedPostAttribute } = select( 'core/editor' );
		const { getPostType } = select( 'core' );

		return {
			pageTemplate: getEditedPostAttribute( 'template' ),
			postType: getPostType( getEditedPostAttribute( 'type' ) ),
		};
	} ),
)( pageTemplateBodyClass );

/**
 * Register plugin in Editor
 */
registerPlugin( 'gt-theme-settings', {
	render: plugin,
} );
