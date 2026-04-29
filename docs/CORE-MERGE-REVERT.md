# Core-merge revert checklist

This plugin demonstrates how to integrate with the [Validation API](https://github.com/troychaplin/validation-api) plugin by registering block, meta, and editor validation checks. The Validation API plugin uses `validation_api_*` names in its standalone form for WordPress.org plugin directory compliance, but renames everything back to `wp_*` if/when it merges into Gutenberg core.

**When to use this doc:** the Validation API has merged into Gutenberg core (or the Gutenberg plugin) and is shipping under its core-style names. At that point, this example plugin needs a small rename pass to keep working.

## What changes

This plugin consumes three public registration functions from the Validation API:

| Standalone (current) | Core (target after merge) |
|---|---|
| `validation_api_register_block_check()` | `wp_register_block_validation_check()` |
| `validation_api_register_meta_check()` | `wp_register_meta_validation_check()` |
| `validation_api_register_editor_check()` | `wp_register_editor_validation_check()` |

JS-side filter names (`editor.validateBlock`, `editor.validateMeta`, `editor.validateEditor`) stay the same — they're already core-style.

## What to change in this plugin

### 1. PHP function calls

Three files contain the function calls and their `function_exists()` guards:

- [`Functions/Check_Album_Cards.php`](../Functions/Check_Album_Cards.php) — 4 calls + 1 guard for `validation_api_register_block_check`
- [`Functions/Check_Band_Meta.php`](../Functions/Check_Band_Meta.php) — 3 calls + 1 guard for `validation_api_register_meta_check`
- [`Functions/Check_Content_Editor.php`](../Functions/Check_Content_Editor.php) — 2 calls + 1 guard for `validation_api_register_editor_check`

Mechanical find-and-replace from the plugin root:

```bash
sed -i '' \
  -e 's/validation_api_register_block_check/wp_register_block_validation_check/g' \
  -e 's/validation_api_register_meta_check/wp_register_meta_validation_check/g' \
  -e 's/validation_api_register_editor_check/wp_register_editor_validation_check/g' \
  Functions/*.php
```

### 2. Documentation

Find-and-replace `validation_api_register_*_check` → `wp_register_*_validation_check` in `README.md` and `readme.txt` if either references those names.

### 3. Compatibility (optional)

If you want this plugin to work with **both** the standalone Validation API plugin and the post-merge core API during a transition window, define wrapper functions:

```php
if ( ! function_exists( 'wp_register_block_validation_check' ) && function_exists( 'validation_api_register_block_check' ) ) {
    function wp_register_block_validation_check( $block_type, $args ) {
        return validation_api_register_block_check( $block_type, $args );
    }
}
```

(And the same for `_meta_` and `_editor_`.) Then call `wp_register_*_validation_check()` everywhere; the wrapper bridges to the standalone plugin's API when core's version isn't present.

### 4. Verify

After the rename, confirm:
- The plugin activates without a fatal error
- Registered checks show up in the editor (block validation borders/toolbar, meta field warnings, editor sidebar issues)
- Saving a post with intentionally-invalid content surfaces the error and locks the save
- No PHP notices or undefined-function warnings in the error log

## Background

The standalone Validation API plugin originally used `wp_*` naming so the names would match what core would use post-merge. WordPress.org's plugin directory disallows the `wp_*` prefix in third-party plugins (it's reserved for core), so the standalone plugin renamed to `validation_api_*` for plugin directory compliance. The original `wp_*` names are restored as a mechanical find-and-replace at core-merge time.

See the Validation API plugin's [`docs/gutenberg-alignment/core-pr-migration.md`](https://github.com/troychaplin/validation-api/blob/main/docs/gutenberg-alignment/core-pr-migration.md) for the full mapping and the upstream migration plan.
