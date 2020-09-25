@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phan/phan/phan_client
php "%BIN_TARGET%" %*
