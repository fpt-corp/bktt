@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phan/phan/tocheckstyle
php "%BIN_TARGET%" %*
