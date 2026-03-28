# useMetaField Helper

This helper hook provides a **safe, zero-dependency integration** with the Validation API plugin.

It is designed to be copied into your plugin. It automatically detects if the Validation API plugin is active:
- **If active:** It delegates to the plugin's enhanced validation hook (displaying error/warning messages automatically).
- **If inactive:** It falls back to standard WordPress `core/editor` data handling, ensuring your plugin continues to work normally.

## Usage

1. Copy `useMetaField.js` to your project (e.g., `src/scripts/helpers/`).
2. Import it in your sidebar or component.

### Basic Example

The hook returns props compatible with standard WordPress components like `TextControl`, `TextareaControl`, etc.

```javascript
import { TextControl } from '@wordpress/components';
import { useMetaField } from '../helpers/useMetaField';

export default function BandSidebar() {
    // 1. Call the hook with your meta key
    const originProps = useMetaField('band_origin', 'Enter the city of origin.');

    return (
        <PanelBody title="Band Details">
            {/* 2. Spread the props into your control */}
            <TextControl
                label="Origin City"
                {...originProps}
            />
        </PanelBody>
    );
}
```

### Advanced: Customizing `onChange`

The hook provides a default `onChange` handler that saves the value to the post meta. You can extend or override this behavior.

#### Method 1: Extending (Recommended)
Use this if you want to perform an additional action (like logging or updating another state) but **still want the value to be saved** to the database automatically.

```javascript
const originProps = useMetaField('band_origin');

<TextControl
    label="Origin City"
    {...originProps}
    // Define onChange AFTER spreading props
    onChange={(newValue) => {
        console.log('Value changed to:', newValue);

        // CRITICAL: Call the original handler to save the data!
        originProps.onChange(newValue);
    }}
/>
```

#### Method 2: Overriding (Take Control)
Use this if you want to completely handle the saving logic yourself (e.g., validation before saving, or saving to a different store).

```javascript
const originProps = useMetaField('band_origin');

<TextControl
    label="Origin City"
    {...originProps}
    // This completely replaces the hook's saving logic
    onChange={(newValue) => {
        // The data will NOT be saved to post meta automatically anymore.
        // You must handle the save manually here.
        myCustomSaveFunction(newValue);
    }}
/>
```

## API Reference

### `useMetaField(metaKey, [originalHelp])`

#### Parameters

| Parameter | Type | Default | Description |
| :--- | :--- | :--- | :--- |
| `metaKey` | `string` | **Required** | The post meta key to bind to. |
| `originalHelp` | `string` | `''` | (Optional) Standard help text to display. If validation errors exist, they will be appended to this text. |

#### Returns

Returns an object containing the following properties, ready to be spread onto a component:

- **`value`** (`string`): The current value of the meta field.
- **`onChange`** (`function`): Function to update the meta value.
- **`help`** (`string|JSX`): The help text. If the main plugin is active, this may include validation error messages formatted in red/orange.
- **`className`** (`string`): CSS classes. If invalid, includes classes like `ba11y-field` and validation wrappers.

