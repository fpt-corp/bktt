@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phan/phan/phan
php "%BIN_TARGET%" %*
