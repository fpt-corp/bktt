<?php // phpcs:ignoreFile

/**
 * This contains the information needed to convert the function signatures for php 7.0 to php 5.6 (and vice versa)
 *
 * This has two sections.
 * The 'new' section contains function/method names from FunctionSignatureMap (And alternates, if applicable) that do not exist in php7.0 or have different signatures in php 7.1.
 *   If they were just updated, the function/method will be present in the 'added' signatures.
 * The 'old' signatures contains the signatures that are different in php 7.0.
 *   Functions are expected to be removed only in major releases of php. (e.g. php 7.0 removed various functions that were deprecated in 5.6)
 *
 * @see FunctionSignatureMap.php
 *
 * @phan-file-suppress PhanPluginMixedKeyNoKey (read by Phan when analyzing this file)
 *
 * TODO: Add some way to warn about functions such as intdiv or IntlChar if they aren't in the configured target_php_version
 */
return [
'new' => [
    'Closure::call' => ['', 'to'=>'object', '...parameters='=>''],
    'intdiv' => ['int', 'numerator'=>'int', 'divisor'=>'int'],
    'IntlChar::charAge' => ['array', 'char'=>'int|string'],
    'IntlChar::charDigitValue' => ['int', 'codepoint'=>'mixed'],
    'IntlChar::charDirection' => ['int', 'codepoint'=>'mixed'],
    'IntlChar::charFromName' => ['int', 'name'=>'string', 'namechoice='=>'int'],
    'IntlChar::charMirror' => ['mixed', 'codepoint'=>'mixed'],
    'IntlChar::charName' => ['string', 'char'=>'int|string', 'namechoice='=>'int'],
    'IntlChar::charType' => ['int', 'codepoint'=>'mixed'],
    'IntlChar::chr' => ['string', 'codepoint'=>'mixed'],
    'IntlChar::digit' => ['int', 'char'=>'int|string', 'radix='=>'int'],
    'IntlChar::enumCharNames' => ['void', 'start'=>'mixed', 'limit'=>'mixed', 'callback'=>'callable', 'nameChoice='=>'int'],
    'IntlChar::enumCharTypes' => ['void', 'cb='=>'callable'],
    'IntlChar::foldCase' => ['int|string', 'char'=>'int|string', 'options='=>'int'],
    'IntlChar::forDigit' => ['int', 'digit'=>'int', 'radix'=>'int'],
    'IntlChar::getBidiPairedBracket' => ['mixed', 'codepoint'=>'mixed'],
    'IntlChar::getBlockCode' => ['int', 'char'=>'int|string'],
    'IntlChar::getCombiningClass' => ['int', 'codepoint'=>'mixed'],
    'IntlChar::getFC_NFKC_Closure' => ['string', 'char'=>'int|string'],
    'IntlChar::getIntPropertyMaxValue' => ['int', 'property'=>'int'],
    'IntlChar::getIntPropertyMinValue' => ['int', 'property'=>'int'],
    'IntlChar::getIntPropertyMxValue' => ['int', 'property'=>'int'],
    'IntlChar::getIntPropertyValue' => ['int', 'char'=>'int|string', 'property'=>'int'],
    'IntlChar::getNumericValue' => ['float', 'char'=>'int|string'],
    'IntlChar::getPropertyEnum' => ['int', 'alias'=>'string'],
    'IntlChar::getPropertyName' => ['string', 'property'=>'int', 'namechoice='=>'int'],
    'IntlChar::getPropertyValueEnum' => ['int', 'property'=>'int', 'name'=>'string'],
    'IntlChar::getPropertyValueName' => ['string', 'prop'=>'int', 'val'=>'int', 'namechoice='=>'int'],
    'IntlChar::getUnicodeVersion' => ['array'],
    'IntlChar::hasBinaryProperty' => ['bool', 'char'=>'int|string', 'property'=>'int'],
    'IntlChar::isalnum' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isalpha' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isbase' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isblank' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::iscntrl' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isdefined' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isdigit' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isgraph' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isIDIgnorable' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isIDPart' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isIDStart' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isISOControl' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isJavaIDPart' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isJavaIDStart' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isJavaSpaceChar' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::islower' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isMirrored' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isprint' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::ispunct' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isspace' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::istitle' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isUAlphabetic' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isULowercase' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isupper' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isUUppercase' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isUWhiteSpace' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isWhitespace' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::isxdigit' => ['bool', 'codepoint'=>'mixed'],
    'IntlChar::ord' => ['int', 'character'=>'mixed'],
    'IntlChar::tolower' => ['mixed', 'codepoint'=>'mixed'],
    'IntlChar::totitle' => ['mixed', 'codepoint'=>'mixed'],
    'IntlChar::toupper' => ['mixed', 'codepoint'=>'mixed'],
    'preg_replace_callback_array' => ['string|array', 'pattern'=>'array<string,callable(array):string>', 'subject'=>'string|array', 'limit='=>'int', '&w_count='=>'int'],
    'random_bytes' => ['string', 'length'=>'int'],
    'random_int' => ['int', 'min'=>'int', 'max'=>'int'],
    'session_start' => ['bool'],
    'unserialize' => ['mixed', 'variable_representation'=>'string', 'allowed_classes='=>'array{allowed_classes?:string[]|bool}'],
],
'old' => [
    'ereg' => ['int', 'pattern'=>'string', 'string'=>'string', 'regs='=>'array'],
    'ereg_replace' => ['string', 'pattern'=>'string', 'replacement'=>'string', 'string'=>'string'],
    'eregi' => ['int', 'pattern'=>'string', 'string'=>'string', 'regs='=>'array'],
    'eregi_replace' => ['string', 'pattern'=>'string', 'replacement'=>'string', 'string'=>'string'],
    'imagepsbbox' => ['array', 'text'=>'string', 'font'=>'', 'size'=>'int', 'space'=>'int', 'tightness'=>'int', 'angle'=>'float'],
    'imagepsencodefont' => ['bool', 'font_index'=>'resource', 'encodingfile'=>'string'],
    'imagepsextendfont' => ['bool', 'font_index'=>'resource', 'extend'=>'float'],
    'imagepsfreefont' => ['bool', 'font_index'=>'resource'],
    'imagepsloadfont' => ['resource', 'filename'=>'string'],
    'imagepsslantfont' => ['bool', 'font_index'=>'resource', 'slant'=>'float'],
    'imagepstext' => ['array', 'image'=>'resource', 'text'=>'string', 'font_index'=>'resource', 'size'=>'int', 'foreground'=>'int', 'background'=>'int', 'x'=>'int', 'y'=>'int', 'space='=>'int', 'tightness='=>'int', 'angle='=>'float', 'antialias_steps='=>'int'],
    'mssql_bind' => ['bool', 'stmt'=>'resource', 'param_name'=>'string', 'var'=>'mixed', 'type'=>'int', 'is_output='=>'bool', 'is_null='=>'bool', 'maxlen='=>'int'],
    'mssql_close' => ['bool', 'link_identifier='=>'resource'],
    'mssql_connect' => ['resource', 'servername='=>'string', 'username='=>'string', 'password='=>'string', 'new_link='=>'bool'],
    'mssql_data_seek' => ['bool', 'result_identifier'=>'resource', 'row_number'=>'int'],
    'mssql_execute' => ['mixed', 'stmt'=>'resource', 'skip_results='=>'bool'],
    'mssql_fetch_array' => ['array', 'result'=>'resource', 'result_type='=>'int'],
    'mssql_fetch_assoc' => ['array', 'result_id'=>'resource'],
    'mssql_fetch_batch' => ['int', 'result'=>'resource'],
    'mssql_fetch_field' => ['object', 'result'=>'resource', 'field_offset='=>'int'],
    'mssql_fetch_object' => ['object', 'result'=>'resource'],
    'mssql_fetch_row' => ['array', 'result'=>'resource'],
    'mssql_field_length' => ['int', 'result'=>'resource', 'offset='=>'int'],
    'mssql_field_name' => ['string', 'result'=>'resource', 'offset='=>'int'],
    'mssql_field_seek' => ['bool', 'result'=>'resource', 'field_offset'=>'int'],
    'mssql_field_type' => ['string', 'result'=>'resource', 'offset='=>'int'],
    'mssql_free_result' => ['bool', 'result'=>'resource'],
    'mssql_free_statement' => ['bool', 'stmt'=>'resource'],
    'mssql_get_last_message' => ['string'],
    'mssql_guid_string' => ['string', 'binary'=>'string', 'short_format='=>'bool'],
    'mssql_init' => ['resource', 'sp_name'=>'string', 'link_identifier='=>'resource'],
    'mssql_min_error_severity' => ['void', 'severity'=>'int'],
    'mssql_min_message_severity' => ['void', 'severity'=>'int'],
    'mssql_next_result' => ['bool', 'result_id'=>'resource'],
    'mssql_num_fields' => ['int', 'result'=>'resource'],
    'mssql_num_rows' => ['int', 'result'=>'resource'],
    'mssql_pconnect' => ['resource', 'servername='=>'string', 'username='=>'string', 'password='=>'string', 'new_link='=>'bool'],
    'mssql_query' => ['mixed', 'query'=>'string', 'link_identifier='=>'resource', 'batch_size='=>'int'],
    'mssql_result' => ['string', 'result'=>'resource', 'row'=>'int', 'field'=>'mixed'],
    'mssql_rows_affected' => ['int', 'link_identifier'=>'resource'],
    'mssql_select_db' => ['bool', 'database_name'=>'string', 'link_identifier='=>'resource'],
    'mysql_affected_rows' => ['int', 'link_identifier='=>'resource'],
    'mysql_client_encoding' => ['string', 'link_identifier='=>'resource'],
    'mysql_close' => ['bool', 'link_identifier='=>'resource'],
    'mysql_connect' => ['resource', 'server='=>'string', 'username='=>'string', 'password='=>'string', 'new_link='=>'bool', 'client_flags='=>'int'],
    'mysql_create_db' => ['bool', 'database_name'=>'string', 'link_identifier='=>'resource'],
    'mysql_data_seek' => ['bool', 'result'=>'resource', 'row_number'=>'int'],
    'mysql_db_name' => ['string', 'result'=>'resource', 'row'=>'int', 'field='=>'mixed'],
    'mysql_db_query' => ['resource', 'database'=>'string', 'query'=>'string', 'link_identifier='=>'resource'],
    'mysql_drop_db' => ['bool', 'database_name'=>'string', 'link_identifier='=>'resource'],
    'mysql_errno' => ['int', 'link_identifier='=>'resource'],
    'mysql_error' => ['string', 'link_identifier='=>'resource'],
    'mysql_escape_string' => ['string', 'unescaped_string'=>'string'],
    'mysql_fetch_array' => ['array', 'result'=>'resource', 'result_type='=>'int'],
    'mysql_fetch_assoc' => ['array', 'result'=>'resource'],
    'mysql_fetch_field' => ['object', 'result'=>'resource', 'field_offset='=>'int'],
    'mysql_fetch_lengths' => ['array', 'result'=>'resource'],
    'mysql_fetch_object' => ['object', 'result'=>'resource', 'class_name='=>'string', 'params='=>'array'],
    'mysql_fetch_row' => ['array', 'result'=>'resource'],
    'mysql_field_flags' => ['string', 'result'=>'resource', 'field_offset'=>'int'],
    'mysql_field_len' => ['int', 'result'=>'resource', 'field_offset'=>'int'],
    'mysql_field_name' => ['string', 'result'=>'resource', 'field_offset'=>'int'],
    'mysql_field_seek' => ['bool', 'result'=>'resource', 'field_offset'=>'int'],
    'mysql_field_table' => ['string', 'result'=>'resource', 'field_offset'=>'int'],
    'mysql_field_type' => ['string', 'result'=>'resource', 'field_offset'=>'int'],
    'mysql_free_result' => ['bool', 'result'=>'resource'],
    'mysql_get_client_info' => ['string'],
    'mysql_get_host_info' => ['string', 'link_identifier='=>'resource'],
    'mysql_get_proto_info' => ['int', 'link_identifier='=>'resource'],
    'mysql_get_server_info' => ['string', 'link_identifier='=>'resource'],
    'mysql_info' => ['string', 'link_identifier='=>'resource'],
    'mysql_insert_id' => ['int', 'link_identifier='=>'resource'],
    'mysql_list_dbs' => ['resource', 'link_identifier='=>'resource'],
    'mysql_list_fields' => ['resource', 'database_name'=>'string', 'table_name'=>'string', 'link_identifier='=>'resource'],
    'mysql_list_processes' => ['resource', 'link_identifier='=>'resource'],
    'mysql_list_tables' => ['resource', 'database'=>'string', 'link_identifier='=>'resource'],
    'mysql_num_fields' => ['int', 'result'=>'resource'],
    'mysql_num_rows' => ['int', 'result'=>'resource'],
    'mysql_pconnect' => ['resource', 'server='=>'string', 'username='=>'string', 'password='=>'string', 'client_flags='=>'int'],
    'mysql_ping' => ['bool', 'link_identifier='=>'resource'],
    'mysql_query' => ['resource', 'query'=>'string', 'link_identifier='=>'resource'],
    'mysql_real_escape_string' => ['string', 'unescaped_string'=>'string', 'link_identifier='=>'resource'],
    'mysql_result' => ['string', 'result'=>'resource', 'row'=>'int', 'field='=>'mixed'],
    'mysql_select_db' => ['bool', 'database_name'=>'string', 'link_identifier='=>'resource'],
    'mysql_set_charset' => ['bool', 'charset'=>'string', 'link_identifier='=>'resource'],
    'mysql_stat' => ['string', 'link_identifier='=>'resource'],
    'mysql_tablename' => ['string', 'result'=>'resource', 'i'=>'int'],
    'mysql_thread_id' => ['int', 'link_identifier='=>'resource'],
    'mysql_unbuffered_query' => ['resource', 'query'=>'string', 'link_identifier='=>'resource'],
    'session_start' => ['bool', 'options='=>'array'],
    'split' => ['array<int,string>', 'pattern'=>'string', 'string'=>'string', 'limit='=>'int'],
    'spliti' => ['array<int,string>', 'pattern'=>'string', 'string'=>'string', 'limit='=>'int'],
    'sql_regcase' => ['string', 'string'=>'string'],
    'sybase_affected_rows' => ['int', 'link_identifier='=>'resource'],
    'sybase_close' => ['bool', 'link_identifier='=>'resource'],
    'sybase_connect' => ['resource', 'servername='=>'string', 'username='=>'string', 'password='=>'string', 'charset='=>'string', 'appname='=>'string', 'new='=>'bool'],
    'sybase_data_seek' => ['bool', 'result_identifier'=>'resource', 'row_number'=>'int'],
    'sybase_deadlock_retry_count' => ['void', 'retry_count'=>'int'],
    'sybase_fetch_array' => ['array', 'result'=>'resource'],
    'sybase_fetch_assoc' => ['array', 'result'=>'resource'],
    'sybase_fetch_field' => ['object', 'result'=>'resource', 'field_offset='=>'int'],
    'sybase_fetch_object' => ['object', 'result'=>'resource', 'object='=>'mixed'],
    'sybase_fetch_row' => ['array', 'result'=>'resource'],
    'sybase_field_seek' => ['bool', 'result'=>'resource', 'field_offset'=>'int'],
    'sybase_free_result' => ['bool', 'result'=>'resource'],
    'sybase_get_last_message' => ['string'],
    'sybase_min_client_severity' => ['void', 'severity'=>'int'],
    'sybase_min_error_severity' => ['void', 'severity'=>'int'],
    'sybase_min_message_severity' => ['void', 'severity'=>'int'],
    'sybase_min_server_severity' => ['void', 'severity'=>'int'],
    'sybase_num_fields' => ['int', 'result'=>'resource'],
    'sybase_num_rows' => ['int', 'result'=>'resource'],
    'sybase_pconnect' => ['resource', 'servername='=>'string', 'username='=>'string', 'password='=>'string', 'charset='=>'string', 'appname='=>'string'],
    'sybase_query' => ['mixed', 'query'=>'string', 'link_identifier='=>'resource'],
    'sybase_result' => ['string', 'result'=>'resource', 'row'=>'int', 'field'=>'mixed'],
    'sybase_select_db' => ['bool', 'database_name'=>'string', 'link_identifier='=>'resource'],
    'sybase_set_message_handler' => ['bool', 'handler'=>'callable', 'connection='=>'resource'],
    'sybase_unbuffered_query' => ['resource', 'query'=>'string', 'link_identifier'=>'resource', 'store_result='=>'bool'],
    'unserialize' => ['mixed', 'variable_representation'=>'string'],
]
];
