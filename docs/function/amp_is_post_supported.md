## Function `amp_is_post_supported`

```php
function amp_is_post_supported( $post );
```

Determine whether a given post supports AMP.

### Arguments

* `\WP_Post $post` - Post.

### Return value

`bool` - Whether the post supports AMP.

### Source

:link: [includes/amp-helper-functions.php:823](../../includes/amp-helper-functions.php#L823-L825)

<details>
<summary>Show Code</summary>

```php
function amp_is_post_supported( $post ) {
	return 0 === count( AMP_Post_Type_Support::get_support_errors( $post ) );
}
```

</details>
