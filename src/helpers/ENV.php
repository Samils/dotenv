<?php
/**
 * Samils\Functions
 * @version 1.0
 * @author Sammy
 *
 * @keywords Samils, ils, ils-global-functions
 * ------------------------------------
 * - Autoload, application dependencies
 *
 * Make sure the command base internal function is not
 * declared in the php global scope defore creating
 * it.
 * It ensures that the script flux is not interrupted
 * when trying to run the current command by the cli
 * API.
 * ----
 * @Function Name: ENV
 * @Function Description: Get An Environment variable value
 * @Function Args:
 */
if (!function_exists ('ENV')) {
/**
 * @version 1.0
 *
 * THE CURRENT ILS FUNCTION IS PROVIDED
 * TO AID THE DEVELOPMENT PROCESS IN ORDER
 * IT GET IN THE SAME WAY WHEN MOVING IT FROM
 * ANOTHER TO ANOTHER ENVIRONMENT.
 *
 * Note: on condition that this is an automatically
 * generated file, it should not be directly changed
 * without saving whole the changes into the original
 * repository source.
 *
 * @author Agostinho Sam'l
 * @keywords env
 */
function ENV () {
  return forward_static_call_array (
    [ ENV::class, 'Get' ], func_get_args ()
  );
}}
