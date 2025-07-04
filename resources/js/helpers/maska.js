/**
 * Creates mask options configuration based on field settings
 *
 * @param {Object} field - Field configuration object
 * @returns {Object} - Configured mask options
 */
export function createMaskOptions(field) {
    // Return empty object if no field is provided
    if (!field || !field.mask || field.mask === '') {
        return {}
    }

    // Create options object with mask
    const options = {
        mask: tryParseJson(field.mask),
    };

    // Add custom tokens if provided
    if (field.tokens) {
        options.tokens = tryParseJson(field.tokens)
    }

    // Add eager option if provided
    if (field.eager) {
        options.eager = field.eager
    }

    // Add reversed option if provided
    if (field.reversed) {
        options.reversed = field.reversed
    }

    // Return configured options
    return options;
}


/**
 * Attempts to parse a string as JSON.
 * Returns the parsed object/array if successful, otherwise returns the original string.
 *
 * @param {any} value - The value to potentially parse.
 * @returns {any} - Parsed JSON or the original value.
 */
function tryParseJson(value) {
  if (typeof value !== 'string') {
      return value;
  }

  if ((value.startsWith('{') && value.endsWith('}')) || (value.startsWith('[') && value.endsWith(']'))) {
      try {
          return JSON.parse(value);
      } catch (e) {
          // Parsing failed, return the original string
          return value;
      }
  }

  return value;
}
