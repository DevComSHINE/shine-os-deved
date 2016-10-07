@ECHO OFF
SET BIN_TARGET=%~dp0/../mrjgreen/db-sync/bin/sync
php "%BIN_TARGET%" %*
