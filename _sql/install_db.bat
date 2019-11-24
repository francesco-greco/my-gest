set OLD_DIR=%CD%
set SQL_SCRIPTS_DIR=c:\_Lavoro\sources\med-chhab\_sql
set TARGET_DATABASE=med_chhab_app

cd c:\xampp\mysql\bin
mysql.exe --default-character-set=UTF8 -u root %TARGET_DATABASE% < %SQL_SCRIPTS_DIR%\regime_fiscale.sql