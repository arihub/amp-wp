## Function `amp_is_request`

```php
function amp_is_request();
```

Determine whether the current request is for an AMP page.

This function cannot be called before the parse_query action because it needs to be able to determine the queried object is able to be served as AMP. If &#039;amp&#039; theme support is not present, this function returns true just if the query var is present. If theme support is present, then it returns true in transitional mode if an AMP template is available and the query var is present, or else in standard mode if just the template is available.

### Return value

`bool` - Whether it is the AMP endpoint.

### Source

:link: [includes/amp-helper-functions.php:856](../../includes/amp-helper-functions.php#L856-L889)

<details>
<summary>Show Code</summary>

```php
function amp_is_request() {
	global $wp_query;

	if ( AMP_Validation_Manager::$is_validate_request ) {
		return true;
	}

	$is_amp_url = (
		amp_is_canonical()
		||
		isset( $_GET[ amp_get_slug() ] ) // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		||
		(
			$wp_query instanceof WP_Query
			&&
			false !== $wp_query->get( amp_get_slug(), false )
		)
	);

	// If AMP is not available, then it's definitely not an AMP endpoint.
	if ( ! amp_is_available() ) {
		// But, if WP_Query was not available yet, then we will just assume the query is supported since at this point we do
		// know either that the site is in Standard mode or the URL was requested with the AMP query var. This can still
		// produce an undesired result when a Standard mode site has a post that opts out of AMP, but this issue will
		// have been flagged via _doing_it_wrong() in amp_is_available() above.
		if ( ! did_action( 'wp' ) || ! $wp_query instanceof WP_Query ) {
			return $is_amp_url && AMP_Options_Manager::get_option( Option::ALL_TEMPLATES_SUPPORTED );
		}

		return false;
	}

	return $is_amp_url;
}
```

</details>
