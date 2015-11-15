set projectPath=%~dp0
if %projectPath:~-1%==\ set projectPath=%projectPath:~0,-1%

set releasePath=%projectPath%\.release
mkdir "%releasePath%"

for /f "tokens=*" %%a in ('type version.txt') do set version=%%a

del "%releasePath%\shareical_%version%.zip"
"build_tools\7z.exe" a -r "%releasePath%\shareical_%version%.zip" "%projectPath%\*" -xr!.* -xr!build_tools -xr!build.bat -xr!composer.json -xr!composer.lock -xr!composer.phar -xr!shareical.phpproj -xr!shareical.phpproj.user -xr!shareical.sln
"build_tools\7z.exe" d "%releasePath%\shareical_%version%.zip" components config.php
