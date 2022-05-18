<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait EnumValue
{
    /**
     * Get the enum values for a column in the database and return them as a key value pair where
     * the value is the human readable form.
     *
     * @param string $column name of the enum column
     * @return array key value pair [db_enum_name] => [name_converted to string with correct case]
     */
    public static function getEnumValues($column)
    {
        $instance = new static;

        // Locates the column in the database
        $enumStr = DB::select(DB::raw('SHOW COLUMNS FROM '.$instance->getTable().' WHERE Field = "'.$column.'"'))[0]->Type;

        // Parse string using regex - why you so ugly regex
        preg_match_all("/'([^']+)'/", $enumStr, $enumValues);

        // Return results
        return self::enumToKeyValue(isset($enumValues[1]) ? $enumValues[1] : []);

    }

    /**
     * Create an associated array from database enum values by converting the name into a readable form
     * and using as the value in the array with the enum value being a key.
     *
     * @param array $enum array of values from the enum in the DB
     * @return array $enumKeyValue key value pair [db_enum_name] => [name_converted to string with correct case]
     */
    private static function enumToKeyValue($enum)
    {
        $enumKeyValue = [];
        foreach($enum as $key)
        {
            $value = ucwords(implode(' ', explode('_', $key)));
            $enumKeyValue[$key] = $value;
        }

        return $enumKeyValue;
    }

}