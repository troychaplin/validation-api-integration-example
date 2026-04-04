# Validation API Integration Example

A reference plugin demonstrating how to integrate with the Validation API plugin.

This plugin serves as a working example for developers who want to:
1. Register block-level validation checks
2. Register editor-level content checks
3. Register meta field validation checks
4. Implement client-side validation logic via JavaScript filters

## Features

### Custom Blocks

- **Album Card Block** (`validation-api-example/album-card`)
  - Displays an album title, release date, and description
  - Includes multiple validation checks
- **Card Grid Block** (`validation-api-example/card-grid`)
  - Parent block for arranging album cards in a grid layout

### Custom Post Type

- **Band Post Type** (`band`)
  - Custom post type for managing band information
  - Custom taxonomy (Genre) for categorizing bands
  - Three validated meta fields:
    - **City of Origin** (`band_origin`)
    - **Record Label** (`band_record_label`)
    - **First Album** (`band_first_album`)
  - Custom plugin sidebar with validated meta fields

### Validation Checks

#### Block Checks (Album Card)

1. **Heading Text** (`check_album_heading_text`) - Validates that heading content exists
2. **Release Date** (`check_album_release_date`) - Ensures release date is provided
3. **Source Link** (`check_album_source_link`) - Validates that a reference link is provided
4. **Inner Block Count** (`check_album_innerblock_count`) - Validates inner block structure

#### Editor Checks (Band Post Type)

1. **First Block Heading** (`first_block_heading`) - First block must be a Heading block
2. **Max Paragraphs** (`max_paragraphs`) - Limits paragraph blocks to 3

#### Meta Checks (Band Post Type)

1. **City of Origin** (`band_origin`) - Required field
2. **Record Label** (`band_record_label`) - Required field
3. **First Album** (`band_first_album`) - Required field

## Code Overview

### 1. Registering Block Checks (PHP)

```php
// Functions/Check_Album_Cards.php
validation_api_register_plugin(
    array( 'name' => 'Validation API Example - Album Cards' ),
    function () {
        validation_api_register_block_check( 'validation-api-example/album-card', array(
            'name'        => 'check_album_heading_text',
            'level'       => 'error',
            'error_msg'   => __( 'A title is required.', 'validation-api-example' ),
            'warning_msg' => __( 'Consider adding a title.', 'validation-api-example' ),
            'description' => __( 'Validates the album title.', 'validation-api-example' ),
        ) );
    }
);
```

### 2. Implementing Validation Logic (JavaScript)

```javascript
// src/scripts/checks/album-card-check.js
addFilter(
    'validation_api_validate_block',
    'validation-api-example/validation',
    (isValid, blockType, attributes, checkName) => {
        if (blockType !== 'validation-api-example/album-card') return isValid;
        if (checkName === 'check_album_heading_text') {
            return !!(attributes.headingText && attributes.headingText.trim());
        }
        return isValid;
    }
);
```

### 3. Registering Meta Checks (PHP)

```php
// Functions/Check_Band_Meta.php
validation_api_register_meta_check( 'band', array(
    'name'        => 'required',
    'meta_key'    => 'band_origin',
    'level'       => 'error',
    'description' => __( 'The city where the band originated', 'validation-api-example' ),
    'error_msg'   => __( 'City of Origin is required.', 'validation-api-example' ),
    'warning_msg' => __( 'City of Origin is recommended.', 'validation-api-example' ),
) );
```

## File Structure

```
validation-api-integration-example/
├── Functions/
│   ├── Check_Album_Cards.php         # Album card block check registration
│   ├── Check_Band_Meta.php           # Band meta field check registration
│   ├── Check_Content_Editor.php      # Editor-level check registration
│   ├── Enqueues.php                  # Script/style enqueuing
│   ├── Plugin_Paths.php              # Plugin path utilities
│   ├── Post_Type.php                 # Band post type, taxonomy, meta registration
│   └── Register_Blocks.php           # Block registration
├── src/
│   ├── blocks/
│   │   ├── album-card/               # Album Card block
│   │   └── card-grid/                # Card Grid block
│   ├── scripts/
│   │   ├── checks/                   # JavaScript validation logic
│   │   │   ├── album-card-check.js   # Block validation filter
│   │   │   ├── editor-checks.js      # Editor validation filter
│   │   │   └── meta-validation.js    # Meta validation filter
│   │   ├── helpers/                  # Helper utilities
│   │   │   └── useMetaField.js       # Meta field hook shim
│   │   └── sidebars/                 # Plugin sidebar components
│   │       └── band-plugin-sidebar.js
├── plugin.php                        # Main plugin file
└── README.md
```

## Integration Points

This example integrates with the Validation API plugin through:

- **Registration Functions**: `validation_api_register_block_check()`, `validation_api_register_meta_check()`, `validation_api_register_editor_check()`
- **Plugin Wrapper**: `validation_api_register_plugin()` for plugin attribution
- **JS Filter Hooks**:
  - `validation_api_validate_block` for block validation
  - `validation_api_validate_meta` for meta field validation
  - `validation_api_validate_editor` for editor-level validation
- **Hooks API**: `window.ValidationAPI.useMetaField` for automatic state management

## Development

```bash
# Install dependencies
npm install
composer install

# Development build with watch mode
npm run start

# Production build
npm run build

# Lint and format code
npm run lint
npm run format
```
