REQUIRED:
1. Requires XAMPP Control Panel (https://www.apachefriends.org/download.html)
2. Project must be put in [Drive]:\xampp\htdocs\[Project] (Default: C:\xampp\htdocs\)
3. Requires SQL Server (SSMS): https://learn.microsoft.com/en-us/ssms/install/install
4. change Uid and PWD in /login/connect.php
"$serverName = "localhost";
$connectionOptions = array(
    "Database" => "dbms_mypham",
    "Uid" => "phuongtuan", <- Change Username
    "PWD" => "phuongtuan2312@", <- Change Passowrd
    "CharacterSet" => "UTF-8"
);"
5. Run 'database.sql' in SQL Server (SSMS)

COMMON ERROR:

- For 'Port 3306 in use by "Unable to open process"!' in XAMPP Control Panel:
open XAMPP Control Panel, click 'Config' button on top-right corner
click 'Service and Port Settings', choose MySql
change Main Port to 3307 (or unoccupied port)
save and close

- For 'undefined function: sqlsrv_connect':
there are 2 php extension files in 'extension' folder
put php_pdo_sqlsrv_82_ts_x64.dll and php_sqlsrv_82_ts_x64.dll (based on php version, mine is 8.2.12 so i choose _82_. Or download more php driver version in https://learn.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server?view=sql-server-ver17) in [Drive]:\xampp\php\ext\
open XAMPP Control Panel, click config button in Apache service, click 'php.ini'
press ctrl + F3 and find 'Module Settings'
add these lines at the bottom:"
extension=php_ftp.dll
extension=php_sqlsrv_82_ts_x64.dll"
save and close

Enjoy! - Hayamij 

Thanks fingxay (Nguyễn Hồng Tài) and tinpro153 (DuckTins) for contributions